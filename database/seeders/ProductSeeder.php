<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Makanan - Burrito
            [
                'name' => 'Biterito Gulai',
                'description' => 'Burrito isi nasi, ayam rasa gulai, tomat, dan timun segar. Perpaduan sempurna cita rasa Nusantara!',
                'price' => 17000,
                'category' => 'makanan',
                'is_available' => true
            ],
            [
                'name' => 'Biterito Rendang',
                'description' => 'Burrito isi nasi, ayam rasa rendang, tomat, dan timun segar. Kaya rempah khas Minang!',
                'price' => 17000,
                'category' => 'makanan',
                'is_available' => true
            ],
            [
                'name' => 'Biterito Balado',
                'description' => 'Burrito isi nasi, ayam rasa balado, tomat, dan timun segar. Pedas gurih yang nagih!',
                'price' => 17000,
                'category' => 'makanan',
                'is_available' => true
            ],

            // Minuman
            [
                'name' => 'Lemonade',
                'description' => 'Minuman lemon segar, manis asam yang menyegarkan.',
                'price' => 10000,
                'category' => 'minuman',
                'is_available' => true
            ],
            [
                'name' => 'Infused Water',
                'description' => 'Air infus buah-buahan segar, sehat dan menyegarkan.',
                'price' => 10000,
                'category' => 'minuman',
                'is_available' => true
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}