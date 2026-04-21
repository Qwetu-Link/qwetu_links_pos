<?php

namespace App\Http\Controllers\v1\product;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\product\StoreProductCatalogRequest;
use App\Http\Requests\v1\product\UpdateProductCatalogRequest;
use App\Models\product\ProductCatalog;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCatalog $productCatalog)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCatalog $productCatalog)
    {
        //
    }
}
