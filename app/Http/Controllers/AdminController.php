<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('final_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'active_products' => Product::where('is_active', true)->count(),
        ];

        // Get recent orders
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->take(10)
            ->get();

        // Get top selling products
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Get revenue chart data (last 7 days)
        $revenueData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(final_amount) as revenue'))
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get user registration data (last 7 days)
        $userData = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as users'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'revenueData',
            'userData'
        ));
    }

    /**
     * Display users management
     */
    public function users()
    {
        $users = User::withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Display products management
     */
    public function products()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = Category::all();

        return view('admin.products', compact('products', 'categories'));
    }

    /**
     * Display orders management
     */
    public function orders()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    /**
     * Display categories management
     */
    public function categories()
    {
        $categories = Category::withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.categories', compact('categories'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Toggle product active status
     */
    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);

        return redirect()->back()->with('success', 'Status produk berhasil diperbarui.');
    }

    /**
     * Delete product
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Display reports
     */
    public function reports()
    {
        // Monthly revenue
        $monthlyRevenue = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(final_amount) as revenue')
        )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Top categories
        $topCategories = Category::select('categories.*', DB::raw('COUNT(order_items.id) as total_sales'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->groupBy('categories.id')
            ->orderBy('total_sales', 'desc')
            ->take(5)
            ->get();

        // User registration by month
        $userRegistrations = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as registrations')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.reports', compact(
            'monthlyRevenue',
            'topCategories',
            'userRegistrations'
        ));
    }

    /**
     * Display settings form
     */
    public function settings()
    {
        $settings = Settings::getSettings();
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update settings data
     */
    public function updateSettings(Request $request)
    {
        $settings = Settings::getSettings();
        $data = $request->validate([
            'short_title' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'favicon' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'google_analytics' => 'nullable|string',
            'google_search' => 'nullable|string',
            'embed_code' => 'nullable|string',
            'tripay_merchant' => 'nullable|string|max:255',
            'tripay_apikey' => 'nullable|string|max:255',
            'tripay_privatekey' => 'nullable|string|max:255',
            'tripay_action' => 'nullable|boolean',
            'whatsapp_appkey' => 'nullable|string|max:255',
            'whatsapp_authkey' => 'nullable|string|max:255',
        ]);
        if ($settings) {
            $settings->update($data);
        }
        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
    }
} 