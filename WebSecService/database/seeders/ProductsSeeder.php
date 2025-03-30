<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create refrigerator products
        $this->createRefrigerators();

        // Create television products
        $this->createTelevisions();

        // Create other products
        $this->createOtherProducts();
    }

    /**
     * Create refrigerator products
     */
    private function createRefrigerators(): void
    {
        $refrigerators = [
            [
                'code' => 'RF-001',
                'name' => 'Double Door Refrigerator',
                'price' => 899.99,
                'stock' => 15,
                'model' => 'CoolMaster X2',
                'description' => 'A spacious double door refrigerator with advanced cooling technology and energy-saving features. Perfect for families.',
                'photo' => 'rf2.jpg'
            ],
            [
                'code' => 'RF-002',
                'name' => 'Smart Refrigerator Pro',
                'price' => 1299.99,
                'stock' => 8,
                'model' => 'SmartCool 3000',
                'description' => 'Smart refrigerator with touch screen display, temperature control via mobile app, and voice command support.',
                'photo' => 'rf3.jpg'
            ],
            [
                'code' => 'RF-003',
                'name' => 'Mini Refrigerator',
                'price' => 299.99,
                'stock' => 25,
                'model' => 'CompactCool',
                'description' => 'Compact refrigerator perfect for dorm rooms, offices, or small apartments. Energy efficient with adjustable shelves.',
                'photo' => 'rf4.jpg'
            ],
            [
                'code' => 'RF-004',
                'name' => 'Side-by-Side Refrigerator',
                'price' => 1499.99,
                'stock' => 10,
                'model' => 'FrostFree Deluxe',
                'description' => 'Large capacity side-by-side refrigerator with water and ice dispenser. Features frost-free technology and adjustable shelving.',
                'photo' => 'rf5.jpg'
            ],
            [
                'code' => 'RF-005',
                'name' => 'French Door Refrigerator',
                'price' => 1899.99,
                'stock' => 5,
                'model' => 'LuxuryFrost Elite',
                'description' => 'Premium French door refrigerator with bottom freezer drawer. Features humidity-controlled crispers and LED lighting throughout.',
                'photo' => 'rf6.jpg'
            ],
        ];

        foreach ($refrigerators as $refrigerator) {
            Product::create($refrigerator);
        }
    }

    /**
     * Create television products
     */
    private function createTelevisions(): void
    {
        $televisions = [
            [
                'code' => 'TV-001',
                'name' => '50" 4K Smart TV',
                'price' => 649.99,
                'stock' => 20,
                'model' => 'UltraView X50',
                'description' => '50-inch 4K Ultra HD Smart TV with HDR support, built-in streaming apps, and voice control compatibility.',
                'photo' => 'lgtv50.jpg'
            ],
            [
                'code' => 'TV-002',
                'name' => '55" QLED Television',
                'price' => 899.99,
                'stock' => 12,
                'model' => 'QuantumColor 55Q',
                'description' => '55-inch QLED TV with Quantum Dot technology for vibrant colors and deep blacks. Features smart functionality and gaming mode.',
                'photo' => 'tv2.jpg'
            ],
            [
                'code' => 'TV-003',
                'name' => '65" OLED Smart TV',
                'price' => 1599.99,
                'stock' => 7,
                'model' => 'PerfectPixel O65',
                'description' => '65-inch OLED TV with perfect black levels, Dolby Vision and Atmos support. Smart features include voice assistants and content recommendations.',
                'photo' => 'tv3.jpg'
            ],
            [
                'code' => 'TV-004',
                'name' => '32" HD Smart TV',
                'price' => 249.99,
                'stock' => 30,
                'model' => 'EssentialView 32',
                'description' => 'Affordable 32-inch HD Smart TV perfect for bedrooms or small spaces. Features built-in Wi-Fi and popular streaming apps.',
                'photo' => 'tv4.jpg'
            ],
        ];

        foreach ($televisions as $television) {
            Product::create($television);
        }
    }

    /**
     * Create other products
     */
    private function createOtherProducts(): void
    {
        $otherProducts = [
            [
                'code' => 'MISC-001',
                'name' => 'Network T-Shirt',
                'price' => 19.99,
                'stock' => 50,
                'model' => 'Tech Apparel NGT',
                'description' => 'Comfortable cotton t-shirt with network gear design. Available in various sizes.',
                'photo' => '1741072392_t-shirt ngt.png'
            ],
            [
                'code' => 'MISC-002',
                'name' => 'Cisco ISR4321 Router',
                'price' => 1299.99,
                'stock' => 5,
                'model' => 'ISR4321/K9',
                'description' => 'Cisco ISR4321 Integrated Services Router with advanced security features and reliable performance for small to medium businesses.',
                'photo' => '1740973597_Cisco-ISR4321.png'
            ],
        ];

        foreach ($otherProducts as $product) {
            Product::create($product);
        }
    }
}
