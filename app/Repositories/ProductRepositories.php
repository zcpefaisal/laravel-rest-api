<?php
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepositories implements CrudInterface{

    // without interface implement process
    // public function getAll() {
    //     return Product::get();
    // }

    // public function findById(int $id){
    //     return Product::find($id);
    // }


    // with interface implement process for giving guideline to jonior developer
    public function getAll(?int $perPage = 10): Paginator
    {
        return Product::paginate($perPage);
    }

    public function getById(int $id): Product
    {
        return Product::find($id);
    }


}
