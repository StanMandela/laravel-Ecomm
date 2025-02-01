<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Products::query()-> orderBy('updated_at', 'desc')->paginate(5);
        return view('products.index',['products' => $products]);
    }

    public function view(Products $product)
    {
        return view('products.view', ['product' => $product]);
    }
}
