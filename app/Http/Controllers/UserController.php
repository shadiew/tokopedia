<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $recentOrders = $user->orders()
            ->with(['orderItems.product'])
            ->latest()
            ->take(5)
            ->get();
            
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->whereIn('status', ['paid', 'completed'])->sum('final_amount');
        $pendingOrders = $user->orders()->pending()->count();
        
        $purchasedProducts = OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['paid', 'completed']);
        })->with('product')->get();

        return view('user.dashboard', compact(
            'user',
            'recentOrders',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'purchasedProducts'
        ));
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Display order history
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with(['orderItems.product'])
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    /**
     * Display order details
     */
    public function orderDetail($orderNumber)
    {
        $user = Auth::user();
        $order = $user->orders()
            ->where('order_number', $orderNumber)
            ->with(['orderItems.product', 'payment'])
            ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }

    /**
     * Display purchased products
     */
    public function purchases()
    {
        $user = Auth::user();
        
        $purchasedProducts = OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['paid', 'completed']);
        })->with(['product', 'order'])
          ->latest()
          ->paginate(12);

        return view('user.purchases', compact('purchasedProducts'));
    }

    /**
     * Display downloads
     */
    public function downloads()
    {
        $user = Auth::user();
        
        $downloads = OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['paid', 'completed']);
        })->where('is_downloaded', true)
          ->with(['product', 'order'])
          ->latest('downloaded_at')
          ->paginate(12);

        return view('user.downloads', compact('downloads'));
    }
}
