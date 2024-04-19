<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepositories;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    use ResponseTrait;

    public $productRepository;

    public function __construct(ProductRepositories $productRepositories)
    {
        $this->productRepository = $productRepositories;
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
            // $productRepositories = new ProductRepositories();
            // return $this->responseSuccess([$productRepositories->getAll()], "Product fatch successlully");

            // Type 3 :: first do dependency injection of product repository in constructor then call
            return $this->responseSuccess([$this->productRepository->getAll(request()->perPage)], "Product fatch successlully");

        }catch (Exception $e){
            return $this->responseError([], $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
