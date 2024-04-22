<?php
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductRepository implements CrudInterface{

    // without interface implement process
    // public function getAll() {
    //     return Product::get();
    // }

    // public function findById(int $id){
    //     return Product::find($id);
    // }


    // with interface implement process for giving guideline to jonior developer
    public function getAll(array $filterData): Paginator
    {
        $filter = $this->filterData($filterData);

        $query = Product::orderBy($filter['orderBy'], $filter['order']);

        if (!empty($filter["search"])) {
            $query->where(function($query) use ($filter){
                $filterable = '%' . $filter['search'] . '%';
                $query->where('title', 'like', $filterable)
                    ->orWhere('slug', 'like', $filterable);
            });
        }

        return $query->paginate($filter['perPage']);
    }

    public function filterData(array $filter)
    {
        $defaultFilterArg = [
            'perPage' => 10,
            'search' => '',
            'orderBy' => 'id',
            'order' => 'desc'
        ];

        return array_merge($defaultFilterArg, $filter);
    }

    public function getById(int $id): ?Product
    {
        $product = Product::find($id);
        if(empty($product)){
            throw new Exception("Product not found", Response::HTTP_NOT_FOUND);
        }
        return $product;
    }

    public function create(array $data): ?Product
    {
        $data = $this->prepareProductData($data);
        return Product::create($data);
    }

    public function update(int $id, array $data): ?Product
    {
        $product = $this->getById($id);

        $product = $product->update($this->prepareProductData($data, $product));

        if ($product) {
            $product = $this->getById($id);
        }

        return $product;
    }

    public function delete(int $id): ?Product
    {
        $product = $this->getById($id);

        $this->imageDelete($product->img_url);

        $deleted = $product->delete();

        if (!$deleted) {
            throw new Exception("Product not deleted", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $product;
    }

    public function prepareProductData(array $data, ?Product $product = null): array
    {
        if (!isset($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        if (!empty($data['image'])) {
            if (!is_null($product)){
                // delete the previus image
                $this->imageDelete($product->img_url);
            }
            $data["image"] = $this->imageUpload($data["image"]);
        }
        $data['user_id'] = Auth::id();
        return $data;
    }

    public function generateUniqueSlug(string $title): string
    {
        return Str::slug(substr($title, 0, 60)) . '_' . time();
    }

    public function imageUpload($image): string {

        $imageName = time() . '.' . $image->extension();

        $image->storePubliclyAs('public', $imageName);

        return $imageName;
    }

    public function imageDelete(?string $imageUrl): void {

        if(!empty($imageUrl)) {

            $imageName = ltrim(strstr($imageUrl, 'storage/'), 'storage/');

            if (!empty($imageName) && Storage::exists('public/', $imageName)){
                Storage::delete('public/'. $imageName);
            }
        }
    }


}
