<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductItemRequest;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('productImages', 'productItems')->get(); // Eager load product images and items
        return response()->json($products);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameproduct' => 'required|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'status' => 'required|integer',
            'brands_id' => 'required|integer',
            'category_id' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image', // Validate each item in the array as an image
            'items' => 'nullable|array',
            'items.*.color' => 'required|string|max:255',
            'items.*.size' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer'
        ]);

        $product = Product::create($request->only(['nameproduct', 'description', 'price', 'status', 'brands_id', 'category_id']));


        if ($request->has('items')) {
            foreach ($request->input('items') as $item) {
                $product->productItems()->create([
                    'color' => $item['color'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity']
                ]);
            }
        }

        return response()->json($product, Response::HTTP_CREATED);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['productImages', 'productItems']); // Eager load images and items when showing a product
        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nameproduct' => 'required|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'status' => 'required|integer',
            'brands_id' => 'required|integer',
            'category_id' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image', // Validate each item in the array as an image
            'items' => 'nullable|array',
            'items.*.color' => 'required|string|max:255',
            'items.*.size' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer'
        ]);

        $product->update($request->only(['nameproduct', 'description', 'price', 'status', 'brands_id', 'category_id']));

        if ($request->hasFile('images')) {
            // Delete old images if needed
            $product->productImages()->delete();
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->productImages()->create(['image' => $path]);
            }
        }

        if ($request->has('items')) {
            // Delete old items if needed
            $product->productItems()->delete();
            foreach ($request->input('items') as $item) {
                $product->productItems()->create([
                    'color' => $item['color'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity']
                ]);
            }
        }

        return response()->json($product);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete related images and items first
        $product->productImages()->delete();
        $product->productItems()->delete();
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_NO_CONTENT);
    }

    /**
     * Display a listing of the product items.
     */
    public function indexItems()
    {
        $productItems = ProductItem::with(['product'])->get();
        return response()->json($productItems);
    }

    /**
     * Store a newly created product item or multiple items in storage.
     */
    public function storeItems(StoreProductItemRequest $request)
    {
        $validated = $request->validated();
        $productItems = [];

        foreach ($validated['items'] as $item) {
            $productItems[] = [
                'product_id' => $validated['product_id'],
                'color' => $item['color'],
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProductItem::insert($productItems);

        return response()->json(['message' => 'Product items added successfully'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified product item.
     */
    public function showItem(ProductItem $productItem)
    {
        return response()->json($productItem->load(['product']));
    }

    /**
     * Update the specified product item in storage.
     */
    public function updateItem(Request $request, ProductItem $productItem)
    {
        $request->validate([
            'product_id' => 'sometimes|integer',
            'color' => 'sometimes|string|max:255',
            'size' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer'
        ]);

        $productItem->update($request->all());

        return response()->json(['message' => 'Product item updated successfully', 'productItem' => $productItem]);
    }

    /**
     * Remove the specified product item from storage.
     */
    public function destroyItem(ProductItem $productItem)
    {
        $productItem->delete();
        return response()->json(['message' => 'Product item deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
