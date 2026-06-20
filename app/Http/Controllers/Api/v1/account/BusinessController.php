<?php

namespace App\Http\Controllers\Api\v1\account;

use App\Events\v1\account\BusinessCreate;
use App\Events\v1\account\BusinessUpdate;
use App\Filters\v1\accounts\BusinessFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\account\StoreBusinessRequest;
use App\Http\Requests\v1\account\UpdateBusinessRequest;
use App\Http\Resources\v1\account\BusinessCollection;
use App\Http\Resources\v1\account\BusinessResource;
use App\Models\account\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new BusinessFilter;

        $filterItems = $filter->transform($request); 

        $business = Business::where($filterItems)->with(['users', 'branches'])->paginate(5)->withQueryString();

        return new BusinessCollection($business);
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
    public function store(StoreBusinessRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $business = Business::create($request->validated());

                $event = new BusinessCreate($business, $request->password);

                event($event);

                return response()->json([
                    'business' => new BusinessResource($business),
                    'status' => true,
                    'message' => 'Business has been created successfully and a verification email has been sent.',
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to Create business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business)
    {
        $business->load(['users', 'branches']);

        return new BusinessResource($business);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessRequest $request, Business $business)
    {
         try {
            return DB::transaction(function () use ($request, $business){

            $event = new BusinessUpdate($business, $request->validated());

            event($event);

            return response()->json([
                'bussiness' => new BusinessResource($business->fresh()),
                'status' => true,
                'message' => 'Business Updated successfully',
            ], 200);
            });
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to Update business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        try {
            $business->delete();

            return response()->json([
                'status' => true,
                'message' => 'Business Deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to Delete business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
