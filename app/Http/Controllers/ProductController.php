<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display product details
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->active()->with('category')->firstOrFail();
        
        // Increment view count
        $product->incrementViewCount();
        
        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->take(4)
            ->get();

        return view('product.show', compact('product', 'relatedProducts'));
    }

    /**
     * Download product file
     */
    public function download($id)
    {
        $product = Product::findOrFail($id);
        
        // Check if user has purchased this product
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengunduh produk.');
        }

        $user = Auth::user();
        $hasPurchased = OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['paid', 'completed']);
        })->where('product_id', $product->id)->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Anda harus membeli produk ini terlebih dahulu.');
        }

        // Check if file exists
        if (!$product->file_path || !Storage::exists($product->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Increment download count
        $product->incrementDownloadCount();

        // Mark as downloaded in order items
        OrderItem::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['paid', 'completed']);
        })->where('product_id', $product->id)->update([
            'is_downloaded' => true,
            'downloaded_at' => now()
        ]);

        // Return file download
        return Storage::download($product->file_path, $product->file_name);
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect()->route('store');
        }

        $products = Product::active()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhereHas('category', function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->paginate(12);

        return view('search', compact('products', 'query'));
    }
}
