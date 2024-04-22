<?php
namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;

interface CrudInterface{


    public function create(array $data): ? Product;

    public function getAll(array $filter): Paginator;

    public function getById(int $id): object|null;

    public function update(int $id, array $data): object|null;

    public function delete(int $id): object|null;
}
