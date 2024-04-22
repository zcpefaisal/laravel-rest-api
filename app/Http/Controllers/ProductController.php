<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\ProductRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    use ResponseTrait;

    public $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try{
            // throw new Exception("Error process", 1);

            // Type 1 :: direct call form database
            // $products = Product::all();
            // return $this->responseSuccess([$products], "Product fatch successlully");

            // Type 2 :: call form product repository and product repository call form database
            // $productRepository = new ProductRepository();
            // return $this->responseSuccess([$productRepository->getAll()], "Product fatch successlully");

            // Type 3 :: first do dependency injection of product repository in constructor then call
            return $this->responseSuccess([$this->productRepository->getAll(request()->all())], "Product fatch successlully");

        }catch (Exception $exception){
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request): JsonResponse
    {
        try{
            return $this->responseSuccess([$this->productRepository->create($request->all())], "Product create successlully");
        }catch (Exception $exception){
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try{
            return $this->responseSuccess([$this->productRepository->getById($id)], "Product fetch successlully");
        }catch (Exception $exception){
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try{
            return $this->responseSuccess([$this->productRepository->update($id, $request->all())], "Product update successlully");
        }catch (Exception $exception){
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            return $this->responseSuccess([$this->productRepository->delete($id)], "Product delete successlully");
        }catch (Exception $exception){
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}
