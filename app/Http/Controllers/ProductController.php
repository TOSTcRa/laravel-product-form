<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->get();
        return view('product.index', compact('products'));
    }
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0'
    ]);

    $product = Product::create($data);
    $product->refresh(); // чтобы created_at появился

    return response()->json(['success' => true, 'product' => $product]);
}


}