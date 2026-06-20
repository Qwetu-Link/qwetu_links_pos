<?php

namespace App\Http\Controllers\Api\v1\product;

use App\Events\v1\product\ProductCatalogCreated;
use App\Filters\v1\product\ProductCatalogFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\product\StoreProductCatalogRequest;
use App\Http\Requests\v1\product\UpdateProductCatalogRequest;
use App\Http\Resources\v1\product\ProductCatalogCollection;
use App\Http\Resources\v1\product\ProductCatalogResource;
use App\Http\Resources\v1\product\ProductCategoryResource;
use App\Models\product\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductCatalogFilter();
        $filterItems = $filter->transform($request); 

        $user = ProductCatalog::where($filterItems)->with(['variants'])->paginate(5)->withQueryString();

        return new ProductCatalogCollection($user);
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
    public function store(StoreProductCatalogRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $event = new ProductCatalogCreated($request->validated());

                event($event);

                return response()->json([
                    'status' => false,
                    'message' => 'Product Created Successfully',
                    'product' => new ProductCategoryResource($event->product),
                ], 200);
            });

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed To Create Products',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCatalog $productCatalog)
    {
        $productCatalog->load(['variants']);
        
        return new ProductCatalogResource($productCatalog);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCatalog $productCatalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCatalogRequest $request, ProductCatalog $productCatalog)
    {
        try {

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed To Update Products',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCatalog $productCatalog)
    {
         try {
            $productCatalog->delete();

            return response()->json([
                'status' => true,
                'message' => 'Product Deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to Delete Product',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
