<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the menu JSON file in the frontend project
        $jsonPath = base_path('../web_sudoku_sushi/src/data/menu.cat.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSON file not found at: {$jsonPath}");
            return;
        }

        $jsonContent = File::get($jsonPath);
        $menuData = json_decode($jsonContent, true);

        if (!isset($menuData['products']) || !is_array($menuData['products'])) {
            $this->command->error("Invalid JSON structure. Expected 'products' array.");
            return;
        }

        $this->command->info("Seeding products from menu.cat.json...");

        foreach ($menuData['products'] as $productData) {
            Product::create([
                'product_code' => (string) $productData['id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'category' => $productData['category'],
                'secondary_category' => $productData['secondaryCategory'] ?? null,
                'image' => $productData['image'],
                'description' => $productData['description'] ?? null,
                'ingredients' => $productData['ingredients'] ?? [],
                'allergens' => $productData['allergens'] ?? [],
            ]);
        }

        $count = Product::count();
        $this->command->info("Successfully seeded {$count} products!");
    }
}
