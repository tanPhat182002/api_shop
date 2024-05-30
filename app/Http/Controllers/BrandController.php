<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the brands.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'  // Adjust validation based on your actual column names and requirements
        ]);

        $brand = Brand::create($request->all());
        return response()->json($brand, Response::HTTP_CREATED);
    }

    /**
     * Display the specified brand.
     */
    public function show(Brand $brand)  // Using Route Model Binding
    {
        return response()->json($brand);
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(Request $request, Brand $brand)  // Using Route Model Binding
    {
        $request->validate([
            'name' => 'required|max:255'  // Adjust validation based on your actual column names and requirements
        ]);

        $brand->update($request->all());
        return response()->json($brand);
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy(Brand $brand)  // Using Route Model Binding
    {
        $brand->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
