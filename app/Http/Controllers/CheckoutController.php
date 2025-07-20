<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Services\TripayService;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        $total = 0;
        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $product->quantity = $quantity;
            $product->subtotal = $subtotal;
        }
        $tripayService = new TripayService();
        $channels = $tripayService->getChannels();
        return view('checkout.index', compact('products', 'total', 'channels'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'nullable|string|max:20',
            'billing_address' => 'nullable|string',
            'payment_method' => 'required', // validasi channel Tripay
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        $total = 0;
        $orderItems = [];
        $tripayItems = [];
        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            $tripayItems[] = [
                'name' => $product->name,
                'price' => (int) $product->price,
                'quantity' => (int) $quantity,
            ];
        }
        $tripayService = new \App\Services\TripayService();
        $invoice = 'INV-' . date('md') . strtoupper(uniqid());
        $signature = $tripayService->generateSignature($invoice, $total);
        $payload = [
            'method' => $request->payment_method,
            'merchant_ref' => $invoice,
            'amount' => $total,
            'customer_name' => $request->billing_name,
            'customer_email' => $request->billing_email,
            'customer_phone' => $request->billing_phone,
            'order_items' => $tripayItems, // FIX: harus array
            'return_url' => route('user.orders'),
            'expired_time' => now()->addHours(24)->timestamp,
            'signature' => $signature,
        ];
        $tripayResponse = $tripayService->createTransaction($payload);
        if (!$tripayResponse || empty($tripayResponse['success'])) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran.');
        }
        try {
            DB::beginTransaction();
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'final_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'notes' => $invoice,
            ]);
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending',
                'transaction_id' => $tripayResponse['data']['reference'] ?? null,
                'payment_details' => json_encode($tripayResponse['data'] ?? []),
            ]);
            DB::commit();
            Session::forget('cart');
            // Redirect ke halaman pembayaran Tripay
            return redirect($tripayResponse['data']['checkout_url'] ?? route('checkout.pending', $order->order_number));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }

    /**
     * Display pending payment page
     */
    public function pending($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['orderItems.product', 'payment'])
            ->firstOrFail();

        return view('checkout.pending', compact('order'));
    }

    /**
     * Display success payment page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['orderItems.product', 'payment'])
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Display order details
     */
    public function order($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['orderItems.product', 'payment'])
            ->firstOrFail();

        return view('checkout.order', compact('order'));
    }
}
