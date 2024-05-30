<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SizeController extends Controller
{
    /**
     * Display a listing of the sizes.
     */
    public function index()
    {
        $sizes = Size::all();
        return response()->json($sizes);
    }

    /**
     * Store a newly created size in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $size = Size::create($request->all());

        return response()->json($size, Response::HTTP_CREATED);
    }

    /**
     * Display the specified size.
     */
    public function show(Size $size)
    {
        return response()->json($size);
    }

    /**
     * Update the specified size in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $size->update($request->all());

        return response()->json($size);
    }

    /**
     * Remove the specified size from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
