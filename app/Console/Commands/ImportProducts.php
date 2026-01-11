<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products {path? : The path to the products JSON file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or update products from a JSON file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path') ?? storage_path('app/products-import.json');

        $this->info("Default path: storage/app/products-import.json. You can provide a custom path:");
        if (!File::exists($path)) {
            $this->error("File not found at: {$path}");
            $this->info("You can place your JSON file at storage/app/products-import.json or provide a custom path.");
            return 1;
        }

        $this->info("Importing products from: {$path}...");

        $jsonContent = File::get($path);
        $data = json_decode($jsonContent, true);

        if (!$data || !isset($data['products']) || !is_array($data['products'])) {
            $this->error("Invalid JSON structure. Expected a 'products' array.");
            return 1;
        }

        $count = 0;
        foreach ($data['products'] as $productData) {
            $product = Product::updateOrCreate(
                ['product_code' => (string) $productData['id']],
                [
                    'name' => $productData['name'],
                    'price' => $productData['price'],
                    'category' => $productData['category'],
                    'secondary_category' => $productData['secondaryCategory'] ?? $productData['secondary_category'] ?? null,
                    'image' => $productData['image'],
                    'description' => $productData['description'] ?? null,
                    'ingredients' => $productData['ingredients'] ?? [],
                    'allergens' => $productData['allergens'] ?? [],
                    'is_active' => $productData['is_active'] ?? $productData['active'] ?? true,
                ]
            );

            if ($product->wasRecentlyCreated) {
                $this->line("Created: {$product->name}");
            } else {
                $this->line("Updated: {$product->name}");
            }
            $count++;
        }

        $this->info("Successfully processed {$count} products!");
        return 0;
    }
}
