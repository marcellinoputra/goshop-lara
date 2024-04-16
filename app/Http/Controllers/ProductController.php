<?php

namespace App\Http\Controllers;

use App\Classses\ApiResponseClass;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth:api');
        $this->productRepository = $productRepository;
    }

    public function index(): JsonResponse
    {
        $products = $this->productRepository->index();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No products found',
                'error' => true
            ], 404);
        }

        return ApiResponseClass::sendResponseWithData(ProductResource::collection($products), 'Successfully Get Data Product', 200);
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $image = $request->file('product_image');
        $image->storeAs('public/product_image', $image->hashName());
        DB::beginTransaction();
        try {
            $product = $this->productRepository->store($data);
            if (!$product) {
                throw new \Exception('Product creation failed');
            }
            DB::commit();
            return ApiResponseClass::sendResponseWithData(new ProductResource($product), "Successfully Create Product", 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
            }
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productRepository->getById($id);
        return ApiResponseClass::sendResponseWithData(new ProductResource($product), 'Successfully Get Data Product By Detail', 200);
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $image = $request->file('product_image');
        $image->storeAs('public/update-product-image', $image->hashName());
        DB::beginTransaction();
        try {
            $updateProduct = $this->productRepository->update($data, $id);
            if (!$updateProduct) {
                throw new \Exception('Product creation failed');
            }
            return ApiResponseClass::sendResponseWithData(new ProductResource($updateProduct), "Successfully Update Product", 200);
        }catch (\Exception $e){
            return ApiResponseClass::rollback($e);
        }
    }

    public function delete($id): JsonResponse
    {
        $this->productRepository->delete($id);
        return ApiResponseClass::sendResponseOnlyMessage('Successfully Delete Product', 200);

    }
}
