<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'user_type' => 'admin',
        ]);

        // Regular users
        User::create([
            'name' => 'Kamal Perera',
            'email' => 'kamal@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'user_type' => 'user',
        ]);

        User::create([
            'name' => 'Nimal Silva',
            'email' => 'nimal@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'user_type' => 'user',
        ]);

        User::create([
            'name' => 'Sunil Fernando',
            'email' => 'sunil@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'user_type' => 'user',
        ]);

        // Categories
        $categories = [
            'Electronics',
            'Clothing',
            'Home & Garden',
            'Sports & Outdoors',
            'Books',
            'Toys & Games',
            'Beauty & Health',
            'Automotive',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['category' => $categoryName]);
        }

        // Products
        $products = [
            [
                'product_title' => 'Wireless Bluetooth Headphones',
                'product_description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life and superior sound quality. Compatible with all Bluetooth devices.',
                'product_quantity' => 50,
                'product_price' => 4500.00,
                'product_image' => 'headphones.png',
                'product_category' => 'Electronics',
            ],
            [
                'product_title' => 'Smartphone Stand & Holder',
                'product_description' => 'Adjustable aluminum smartphone stand for desk use. Compatible with all phone sizes. Anti-slip base ensures stability.',
                'product_quantity' => 120,
                'product_price' => 850.00,
                'product_image' => 'smartphone_stand.png',
                'product_category' => 'Electronics',
            ],
            [
                'product_title' => 'Men\'s Casual T-Shirt',
                'product_description' => 'Comfortable 100% cotton casual t-shirt available in multiple colors. Soft fabric, breathable and durable for everyday wear.',
                'product_quantity' => 200,
                'product_price' => 650.00,
                'product_image' => 'mens_tshirt.png',
                'product_category' => 'Clothing',
            ],
            [
                'product_title' => 'Women\'s Summer Dress',
                'product_description' => 'Elegant floral summer dress made from lightweight fabric. Perfect for casual outings and beach trips. Available in S, M, L, XL.',
                'product_quantity' => 80,
                'product_price' => 1800.00,
                'product_image' => 'womens_dress.png',
                'product_category' => 'Clothing',
            ],
            [
                'product_title' => 'Ceramic Plant Pot Set',
                'product_description' => 'Set of 3 beautiful ceramic plant pots in different sizes. Perfect for indoor plants and succulents. Comes with drainage holes.',
                'product_quantity' => 60,
                'product_price' => 1200.00,
                'product_image' => 'plant_pots.png',
                'product_category' => 'Home & Garden',
            ],
            [
                'product_title' => 'Yoga Mat - Non Slip',
                'product_description' => 'Eco-friendly non-slip yoga mat, 6mm thick for extra cushioning. Ideal for yoga, pilates, and floor exercises. Easy to clean.',
                'product_quantity' => 90,
                'product_price' => 2200.00,
                'product_image' => 'yoga_mat.png',
                'product_category' => 'Sports & Outdoors',
            ],
            [
                'product_title' => 'Programming: Clean Code Book',
                'product_description' => 'A must-read book for every software developer. Learn how to write clean, maintainable and efficient code. Paperback edition.',
                'product_quantity' => 35,
                'product_price' => 3500.00,
                'product_image' => 'clean_code_book.jpg',
                'product_category' => 'Books',
            ],
            [
                'product_title' => 'LED Desk Lamp',
                'product_description' => 'Energy-efficient LED desk lamp with adjustable brightness and color temperature. USB charging port included. Eye-care design.',
                'product_quantity' => 75,
                'product_price' => 1950.00,
                'product_image' => 'led_desk_lamp.jpg',
                'product_category' => 'Electronics',
            ],
            [
                'product_title' => 'Wooden Building Blocks',
                'product_description' => 'Classic wooden building blocks set with 50 pieces. Helps develop creativity and motor skills in children aged 3 and above.',
                'product_quantity' => 45,
                'product_price' => 1100.00,
                'product_image' => 'wooden_blocks.jpg',
                'product_category' => 'Toys & Games',
            ],
            [
                'product_title' => 'Moisturizing Face Cream',
                'product_description' => 'Hydrating face cream with SPF 30 protection. Suitable for all skin types. Enriched with vitamin C and aloe vera extract.',
                'product_quantity' => 150,
                'product_price' => 980.00,
                'product_image' => 'face_cream.jpg',
                'product_category' => 'Beauty & Health',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
