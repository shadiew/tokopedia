<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            
            foreach ($products as $product) {
                $quantity = $cart[$product->id];
                $subtotal = $product->price * $quantity;
                $total += $subtotal;
                $product->quantity = $quantity;
                $product->subtotal = $subtotal;
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $id)
    {
        $product = Product::active()->findOrFail($id);
        $cart = Session::get('cart', []);
        
        $quantity = $request->get('quantity', 1);
        
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->get('quantity', 1);
        
        if ($quantity > 0) {
            $cart[$id] = $quantity;
        } else {
            unset($cart[$id]);
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Get cart count for navbar
     */
    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        return response()->json(['count' => count($cart)]);
    }
}
