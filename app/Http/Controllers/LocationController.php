<?php

namespace App\Http\Controllers;

use App\Classses\ApiResponseClass;
use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Http\Resources\LocationResource;
use App\Repositories\LocationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->middleware('auth:api');
        $this->locationRepository = $locationRepository;
    }

    public function index():JsonResponse
    {
        $location = $this->locationRepository->index();

        if($location->isEmpty()){
            return response()->json([
                'status' => 400,
                'message' => 'No Location Found',
                'error' => true
            ], 400);
        }

        return ApiResponseClass::sendResponseWithData(LocationResource::collection($location), 'Successfully Get Location', 200);
    }

    public function show($id){
        $location = $this->locationRepository->getById($id);
        return ApiResponseClass::sendResponseWithData(new LocationResource($location), 'Successfully Get Data Location By ID', 200);
    }

    public function store(LocationStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $location = $this->locationRepository->store($data);
            if(!$location){
                throw new \Exception('Location Creation Failed');
            }
            DB::commit();
            return ApiResponseClass::sendResponseWithData(new LocationResource($location), 'Successfully Create Location', 201);
        }catch(\Exception $e){
            return ApiResponseClass::rollback($e);
        }
    }

    public function update(LocationUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $updateLocation = $this->locationRepository->update($data, $id);
            if(!$updateLocation){
                throw new \Exception('Location Update Failed');
            }
            DB::commit();
            return ApiResponseClass::sendResponseWithData(new LocationResource($updateLocation), 'Successfully Updated Location Data', 201);
        }catch (\Exception $e){
            return ApiResponseClass::rollback($e);
        }
    }

    public function delete(int $id):JsonResponse
    {
        $this->locationRepository->delete($id);
        return ApiResponseClass::sendResponseOnlyMessage('Successfully Delete Location Data', 200);
    }
}
