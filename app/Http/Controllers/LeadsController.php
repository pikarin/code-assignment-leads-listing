<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexLeadRequest;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Repositories\LeadRepositoryContract;
use Illuminate\Http\JsonResponse;

class LeadsController extends Controller
{
    public function __construct(protected LeadRepositoryContract $repository)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexLeadRequest $request)
    {
        $leads = $this->repository->all($request->input('quality'));

        return response()->json([
            'data' => $leads,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request): JsonResponse
    {
        $lead = $this->repository->create($request->validated());

        return response()->json([
            'message' => 'created',
            'data' => $lead,
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $lead = $this->repository->find($id);

        return response()->json([
            'data' => $lead,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request): JsonResponse
    {
        $this->repository->update($request->validated());

        $lead = $this->repository->find($request->lead_id);

        return response()->json([
            'message' => 'created',
            'data' => $lead->refresh()->load('address'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json([
            'message' => 'created',
        ], JsonResponse::HTTP_NO_CONTENT);
    }
}
