<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 
use Illuminate\Support\Facades\Gate;

class ProductsController extends Controller 
{   
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Products::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $fields=  $request->validate([
            'title'=>'required|max:255',
            'description'=>'required',
            'slug'=>'required',
            'price'=>'required',
    ]);
    //
    $product= $request->user()->products()->create($fields);
        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        Gate::authorize('modify',$product);
        $fields=  $request->validate([
            'title'=>'required|max:255',
            'description'=>'required',
            'slug'=>'required',
            'price'=>'required',
    ]);
         $product->update($fields);
        return $product;
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        Gate::authorize('modify',$product);
        $product-> delete();
         return ['Message'=> "Deleted Post ".$product["id"]];
    }
}
