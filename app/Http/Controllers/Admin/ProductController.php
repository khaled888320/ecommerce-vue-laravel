<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(20);

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|min:3',
            'description' => 'required|string|min:10',
            'price'       => 'required|numeric|min:0.01',
            'sale_price'  => 'nullable|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product = Product::create([
            ...$request->validated(),
            'slug' => Str::slug($request->name),
        ]);

        $product->load('category');

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'category_id' => 'exists:categories,id',
            'name'        => 'string|min:3',
            'description' => 'string|min:10',
            'price'       => 'numeric|min:0.01',
            'sale_price'  => 'nullable|numeric|min:0.01',
            'stock'       => 'integer|min:0',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($request->has('name')) {
            $product->slug = Str::slug($request->name);
        }

        $product->update($request->validated());
        $product->load('category');

        return response()->json($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'Produs șters!']);
    }
}