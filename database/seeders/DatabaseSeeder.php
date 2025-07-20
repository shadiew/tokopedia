<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Template Website', 'slug' => 'template-website', 'description' => 'Template website responsif dan modern'],
            ['name' => 'E-Book', 'slug' => 'e-book', 'description' => 'Buku digital dalam berbagai kategori'],
            ['name' => 'Software', 'slug' => 'software', 'description' => 'Aplikasi dan software berkualitas'],
            ['name' => 'Template PowerPoint', 'slug' => 'template-powerpoint', 'description' => 'Template presentasi profesional'],
            ['name' => 'Icon Pack', 'slug' => 'icon-pack', 'description' => 'Kumpulan icon dan ilustrasi'],
            ['name' => 'Font', 'slug' => 'font', 'description' => 'Font dan tipografi berkualitas'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@digitalstore.com',
                'phone' => '081234567890',
                'role' => 'admin',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '081234567891',
                'role' => 'customer',
                'address' => 'Jl. User No. 1, Jakarta',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '081234567892',
                'role' => 'customer',
                'address' => 'Jl. Member No. 1, Jakarta',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Template Website Portfolio',
                'slug' => 'template-website-portfolio',
                'description' => 'Template website portfolio profesional dengan desain modern dan responsif. Cocok untuk freelancer, designer, dan developer.',
                'price' => 150000,
                'category_id' => 1,
                'is_featured' => true,
                'is_recommended' => true,
                'is_bestseller' => true,
                'file_name' => 'portfolio-template.zip',
                'file_size' => 2621440, // 2.5 MB in bytes
                'download_count' => 45,
                'view_count' => 120,
                'meta_title' => 'Template Website Portfolio - DigitalStore',
                'meta_description' => 'Template website portfolio profesional dengan desain modern dan responsif.',
                'meta_keywords' => 'template, website, portfolio, responsive, modern',
            ],
            [
                'name' => 'E-Book Panduan Laravel',
                'slug' => 'e-book-panduan-laravel',
                'description' => 'E-book lengkap panduan belajar Laravel dari dasar hingga advanced. Dilengkapi dengan contoh project dan best practices.',
                'price' => 75000,
                'category_id' => 2,
                'is_featured' => true,
                'is_recommended' => false,
                'is_bestseller' => true,
                'file_name' => 'laravel-guide.pdf',
                'file_size' => 15938355, // 15.2 MB in bytes
                'download_count' => 89,
                'view_count' => 234,
                'meta_title' => 'E-Book Panduan Laravel - DigitalStore',
                'meta_description' => 'E-book lengkap panduan belajar Laravel dari dasar hingga advanced.',
                'meta_keywords' => 'laravel, ebook, tutorial, php, framework',
            ],
            [
                'name' => 'Software Photo Editor Pro',
                'slug' => 'software-photo-editor-pro',
                'description' => 'Software editing foto profesional dengan fitur lengkap. Mendukung berbagai format file dan efek editing.',
                'price' => 250000,
                'category_id' => 3,
                'is_featured' => false,
                'is_recommended' => true,
                'is_bestseller' => false,
                'file_name' => 'photo-editor-pro.exe',
                'file_size' => 48024791, // 45.8 MB in bytes
                'download_count' => 23,
                'view_count' => 67,
                'meta_title' => 'Software Photo Editor Pro - DigitalStore',
                'meta_description' => 'Software editing foto profesional dengan fitur lengkap.',
                'meta_keywords' => 'photo editor, software, editing, professional',
            ],
            [
                'name' => 'Template PowerPoint Business',
                'slug' => 'template-powerpoint-business',
                'description' => 'Template PowerPoint untuk presentasi bisnis dengan desain elegan dan profesional. Dilengkapi dengan 50+ slide template.',
                'price' => 50000,
                'category_id' => 4,
                'is_featured' => true,
                'is_recommended' => false,
                'is_bestseller' => false,
                'file_name' => 'business-presentation.pptx',
                'file_size' => 8703181, // 8.3 MB in bytes
                'download_count' => 156,
                'view_count' => 445,
                'meta_title' => 'Template PowerPoint Business - DigitalStore',
                'meta_description' => 'Template PowerPoint untuk presentasi bisnis dengan desain elegan.',
                'meta_keywords' => 'powerpoint, template, business, presentation',
            ],
            [
                'name' => 'Icon Pack Modern',
                'slug' => 'icon-pack-modern',
                'description' => 'Kumpulan 500+ icon modern dalam format SVG dan PNG. Cocok untuk website, aplikasi, dan desain grafis.',
                'price' => 35000,
                'category_id' => 5,
                'is_featured' => false,
                'is_recommended' => true,
                'is_bestseller' => true,
                'file_name' => 'modern-icons.zip',
                'file_size' => 13316915, // 12.7 MB in bytes
                'download_count' => 234,
                'view_count' => 567,
                'meta_title' => 'Icon Pack Modern - DigitalStore',
                'meta_description' => 'Kumpulan 500+ icon modern dalam format SVG dan PNG.',
                'meta_keywords' => 'icon, pack, modern, svg, png',
            ],
            [
                'name' => 'Font Collection Premium',
                'slug' => 'font-collection-premium',
                'description' => 'Koleksi 100+ font premium berkualitas tinggi. Termasuk font serif, sans-serif, dan display fonts.',
                'price' => 100000,
                'category_id' => 6,
                'is_featured' => true,
                'is_recommended' => true,
                'is_bestseller' => false,
                'file_name' => 'premium-fonts.zip',
                'file_size' => 26633830, // 25.4 MB in bytes
                'download_count' => 78,
                'view_count' => 189,
                'meta_title' => 'Font Collection Premium - DigitalStore',
                'meta_description' => 'Koleksi 100+ font premium berkualitas tinggi.',
                'meta_keywords' => 'font, collection, premium, typography',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create sample orders
        $orders = [
            [
                'user_id' => 2,
                'order_number' => 'ORD-2024-001',
                'total_amount' => 150000,
                'final_amount' => 150000,
                'status' => 'completed',
                'billing_name' => 'John Doe',
                'billing_email' => 'john@example.com',
                'billing_phone' => '081234567891',
                'billing_address' => 'Jl. User No. 1, Jakarta',
                'notes' => 'Pesanan pertama',
            ],
            [
                'user_id' => 3,
                'order_number' => 'ORD-2024-002',
                'total_amount' => 125000,
                'final_amount' => 125000,
                'status' => 'pending',
                'billing_name' => 'Jane Smith',
                'billing_email' => 'jane@example.com',
                'billing_phone' => '081234567892',
                'billing_address' => 'Jl. Member No. 1, Jakarta',
                'notes' => 'Pesanan kedua',
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        // Create sample order items
        $orderItems = [
            [
                'order_id' => 1,
                'product_id' => 1,
                'product_name' => 'Template Website Portfolio',
                'quantity' => 1,
                'price' => 150000,
                'subtotal' => 150000,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'product_name' => 'E-Book Panduan Laravel',
                'quantity' => 1,
                'price' => 75000,
                'subtotal' => 75000,
            ],
            [
                'order_id' => 2,
                'product_id' => 4,
                'product_name' => 'Template PowerPoint Business',
                'quantity' => 1,
                'price' => 50000,
                'subtotal' => 50000,
            ],
        ];

        foreach ($orderItems as $item) {
            OrderItem::create($item);
        }

        // Create sample payments
        $payments = [
            [
                'order_id' => 1,
                'payment_method' => 'bank_transfer',
                'amount' => 150000,
                'status' => 'success',
                'transaction_id' => 'TXN-2024-001',
                'paid_at' => now(),
            ],
            [
                'order_id' => 2,
                'payment_method' => 'credit_card',
                'amount' => 125000,
                'status' => 'pending',
                'transaction_id' => 'TXN-2024-002',
                'paid_at' => null,
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}
