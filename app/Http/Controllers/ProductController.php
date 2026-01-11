<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products.
     * Supports optional category filtering via query parameter.
     */
    public function index(Request $request): JsonResponse
    {
        $products = $this->productService->getActiveProducts($request->query('category'));

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'count' => $products->count(),
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Get all unique categories.
     */
    public function categories(): JsonResponse
    {
        $categories = $this->productService->getUniqueCategories();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}
