<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $currencies = Currency::all();
        return view('products.create', compact('categories', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'barcode' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'keywords' => 'nullable',
            'active' => 'boolean',
            'currency_id' => 'required|exists:currencies,id',
            'price' => 'required|numeric',
        ]);

        $imagePath = "";

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Product::create([
            "name" => $validatedData["name"],
            "barcode" => $validatedData["barcode"],
            "image" => $imagePath,
            "category_id" => $validatedData["category_id"],
            "description" => $validatedData["description"],
            "keywords" => $validatedData["keywords"],
            "active" => $validatedData["active"],
            "price" => $validatedData["price"],
            "currency_id" => $validatedData["currency_id"],

        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $currencies = Currency::all();
        return view('products.edit', compact('categories', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'barcode' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'keywords' => 'nullable',
            'active' => 'required|boolean',
            'currency_id' => 'required|exists:currencies,id',
            'price' => 'required|numeric',
        ]);


        $product->update($request->only(['name', 'barcode', 'category_id', 'description', 'image', 'keywords', 'active', 'currency_id']));


        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
