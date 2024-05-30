<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the product images.
     */
    public function index()
    {
        $productImages = ProductImage::with('product')->get(); // Eager load product data
        return response()->json($productImages);
    }

    /**
     * Store a newly created product image in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'image' => 'required|image'
        ]);

        $path = $request->file('image')->store('product_images', 'public');

        $productImage = ProductImage::create([
            'product_id' => $request->product_id,
            'image' => $path
        ]);

        return response()->json($productImage, Response::HTTP_CREATED);
    }

    /**
     * Display the specified product image.
     */
    public function show(ProductImage $productImage)
    {
        $url = asset('storage/product_images' . $productImage->image);
        $productImage->image_url = $url;
        return response()->json($productImage->load('product'));
    }


    /**
     * Update the specified product image in storage.
     */
    public function update(Request $request, ProductImage $productImage)
    {
        $request->validate([
            'product_id' => 'sometimes|required|integer|exists:products,id',
            'image' => 'sometimes|image'
        ]);

        if ($request->has('product_id')) {
            $productImage->product_id = $request->product_id;
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image
            Storage::delete('public/' . $productImage->image);
            // Store new image
            $path = $request->file('image')->store('product_images', 'public');
            $productImage->image = $path;
        }

        $productImage->save();

        return response()->json($productImage);
    }

    /**
     * Remove the specified product image from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        // Delete the image file
        Storage::delete('public/' . $productImage->image);
        $productImage->delete();

        return response()->json(['message' => 'Product image deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
