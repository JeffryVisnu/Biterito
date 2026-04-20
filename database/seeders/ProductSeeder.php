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
                'description' => 'Rasakan gurihnya bumbu gulai autentik yang meresap sempurna ke dalam potongan ayam empuk dan nasi hangat. Dibalut kulit tortila lembut dengan kesegaran ekstra dari irisan tomat dan timun renyah. Biterito Gulai adalah cara baru yang praktis untuk menikmati nikmatnya hidangan rumahan di mana saja',
                'price' => 17000,
                'category' => 'makanan',
                'is_available' => true
            ],
            [
                'name' => 'Biterito Rendang',
                'description' => 'Perpaduan ayam dengan bumbu rendang yang medok dan kaya rempah, disajikan bersama nasi pulen dan sayuran segar, lalu dibungkus rapi dalam tortila hangat. Biterito Rendang siap memanjakan lidahmu dengan ledakan rasa khas Minang di setiap gigitannya',
                'price' => 17000,
                'category' => 'makanan',
                'is_available' => true
            ],
            [
                'name' => 'Biterito Balado',
                'description' => 'Sengatan bumbu balado spesial yang melumuri daging ayam berpadu sangat harmonis dengan nasi, serta segarnya tomat dan timun. Biterito Balado adalah pilihan paling pas buat kamu yang butuh asupan nikmat, praktis, dan dijamin bikin lidah nggak mau berhenti ngunyah',
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