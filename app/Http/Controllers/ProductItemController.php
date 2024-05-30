<?php

namespace App\Http\Controllers;

use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreProductItemRequest;

class ProductItemController extends Controller
{
    /**
     * Display a listing of the product items.
     */
    public function index()
    {
        $productItems = ProductItem::with(['product' ])->get();
        return response()->json($productItems);
    }

    /**
     * Store a newly created product item or multiple items in storage.
     */
    public function store(StoreProductItemRequest $request)
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
    public function show(ProductItem $productItem)
    {
        return response()->json($productItem->load(['product', 'color', 'size']));
    }

    /**
     * Update the specified product item in storage.
     */
    public function update(Request $request, ProductItem $productItem)
    {
        $request->validate([
            'product_id' => 'sometimes|integer',
            'id_color' => 'sometimes|integer',
            'id_size' => 'sometimes|integer',
            'quantity' => 'sometimes|integer'
        ]);

        $productItem->update($request->all());

        return response()->json($productItem);
    }

    /**
     * Remove the specified product item from storage.
     */
    public function destroy(ProductItem $productItem)
    {
        $productItem->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
