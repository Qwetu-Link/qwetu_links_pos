<?php

namespace App\Http\Controllers;

use App\Http\Requests\v1\inventory\StoreInventoryLocationRequest;
use App\Http\Requests\v1\inventory\UpdateInventoryLocationRequest;
use App\Models\inventory\InventoryLocation;

class InventoryLocationController extends Controller
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
    public function store(StoreInventoryLocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryLocation $inventoryLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryLocation $inventoryLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryLocationRequest $request, InventoryLocation $inventoryLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryLocation $inventoryLocation)
    {
        //
    }
}
