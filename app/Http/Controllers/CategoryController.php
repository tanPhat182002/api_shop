<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namecate' => 'required|max:255',
            'status' => 'required|integer'
        ]);

        $category = Category::create($request->all());
        return response()->json($category, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)  // Using Route Model Binding
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)  // Using Route Model Binding
    {
        $request->validate([
            'namecate' => 'required|max:255',
            'status' => 'required|integer'
        ]);

        $category->update($request->all());
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)  // Using Route Model Binding
    {
        $category->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
