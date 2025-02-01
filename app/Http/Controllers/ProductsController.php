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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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
        $search = request('search',false);
        $perPage = request('per_page',10);
        $sortField= request('sort_field','updated_at');
        $sortDirection= request('sort_direction','desc');
        $query = Products::query();
        $query->orderBy($sortField,$sortDirection);
        if($search){
            $query->where('title','like',"%{$search}%")
            ->orWhere('description','like',"%{$search}%");
        }       
        return ProductListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

    /** @var \Illuminate\Http\UploadedFile $image */
    $image = $data['image'] ?? null;
    // Check if image was given and save on local file system
    if ($image) {
        $relativePath = $this->saveImage($image);
        $data['image'] = URL::to(Storage::url($relativePath));
        $data['image_mime'] = $image->getClientMimeType();
        $data['image_size'] = $image->getSize();
    }

    $product = Products::create($data);

    return new ProductsResource($product);  
  }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        return view('products.view', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductsRequest $request, Products $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        // Check if image was given and save on local file system
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();

            // If there is an old image, delete it
            if ($product->image) {
                Storage::deleteDirectory('/public/' . dirname($product->image));
            }
        }

        $product->update($data);
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
private function saveImage(UploadedFile $image)
    {
        $path = 'images/' . Str::random();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' . $image->getClientOriginalName();
    }

}