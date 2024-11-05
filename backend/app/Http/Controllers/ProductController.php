<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Trait\CommonTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use CommonTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(['data' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'cat_id' => 'required|integer|exists:categories,id',
        ]);

        $product = Product::create($validatedData);
        return $this->sendResponse(['data' => $product, 'message' => 'Product saved successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return $this->sendResponse(['data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|max:100|unique:products,sku,' . $id,
            'quantity' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
            'cat_id' => 'sometimes|integer|exists:categories,id',
        ]);

        $product = Product::find($id);
        $product->update($validatedData);
        return $this->sendResponse(['data' => $product, 'message' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return $this->sendResponse(['message' => 'Product deleted successfully']);
    }
}
