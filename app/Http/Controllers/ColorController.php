<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ColorController extends Controller
{
    /**
     * Display a listing of the colors.
     */
    public function index()
    {
        $colors = Color::all();
        return response()->json($colors);
    }

    /**
     * Store a newly created color in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $color = new Color();
        $color->name = $request->name;
        $color->save();

        return response()->json($color, Response::HTTP_CREATED);
    }

    /**
     * Display the specified color.
     */
    public function show(Color $color)
    {
        return response()->json($color);
    }

    /**
     * Update the specified color in storage.
     */
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $color->update($request->all());
        return response()->json($color);
    }

    /**
     * Remove the specified color from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
