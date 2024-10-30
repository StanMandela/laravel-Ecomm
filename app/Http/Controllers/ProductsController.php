<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductsResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 
use Illuminate\Support\Facades\Gate;
use App\Helpers\ApiHelper;
use App\Services\FineractService;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller 
{   
    protected $fineractService;

    public function __construct(FineractService $fineractService)
    {
      //  $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
      $this->fineractService = $fineractService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return ProductListResource::collection(Products::query()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            //   $fields=  $request->validate([
            //         'title'=>'required|max:255',
            //         'description'=>'required',
            //         'slug'=>'required',
            //         'price'=>'required',
            // ]);
            // //
            // $product= $request->user()->products()->create($fields);
            //     return $product;
    return new ProductsResource(Products::create($request->validate()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
      return  new ProductsResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
    //     Gate::authorize('modify',$product);
    //     $fields=  $request->validate([
    //         'title'=>'required|max:255',
    //         'description'=>'required',
    //         'slug'=>'required',
    //         'price'=>'required',
    // ]);
    //      $product->update($fields);
    //     return $product;
        $product ->update($request->validate());
        return new ProductsResource($product);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        // Gate::authorize('modify',$product);
        // $product-> delete();
        //  return ['Message'=> "Deleted Post ".$product["id"]];
        $product->delete();
        return response()->noContent();
    }


    public function makePostTransaction(Request $request)
    {
        // Sample data for the POST transaction
        $url = 'http://127.0.0.1:8000/api/register';
        $postData = [
            "name" => "Jond",
            "description" => "Mandela",
            "position" => 1,
            "isActive" => true,
        ];

      // Validate the request
      $validator = Validator::make($postData, [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'position' => 'required|integer',
        'isActive' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Call the service method to interact with Fineract
    $response = $this->fineractService->createCodeValue($codeId=2,$postData);

    //Get Call 
   // $response = $this->fineractService->getCodeValues();

    //llvar_dump($response);
    // Return the Fineract API response
    return response()->json($response, 200);

}
}