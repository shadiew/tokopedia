<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $featuredProducts = Product::active()->featured()->latest()->take(8)->get();
        $recommendedProducts = Product::active()->recommended()->latest()->take(8)->get();
        $bestsellerProducts = Product::active()->bestseller()->latest()->take(8)->get();
        $latestProducts = Product::active()->latest()->take(8)->get();
        $categories = Category::active()->withCount('products')->take(6)->get();

        // Fallback: jika kosong, pakai produk terbaru
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = $latestProducts;
        }
        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = $latestProducts;
        }
        if ($bestsellerProducts->isEmpty()) {
            $bestsellerProducts = $latestProducts;
        }

        return view('home', compact(
            'featuredProducts',
            'recommendedProducts', 
            'bestsellerProducts',
            'latestProducts',
            'categories'
        ));
    }

    /**
     * Display the store page
     */
    public function store(Request $request)
    {
        $query = Product::active()->with('category');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('download_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::active()->get();

        return view('store', compact('products', 'categories'));
    }

    /**
     * Display products by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();
        $products = $category->products()->active()->paginate(12);

        return view('category', compact('category', 'products'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Display privacy policy page
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Display terms of service page
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Display about page
     */
    public function about()
    {
        return view('about');
    }
}
