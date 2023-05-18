<?php
namespace App\Services;

use App\Repos\ProductRepo;
use App\Exceptions\ItemNotFound;
use App\Exceptions\UserNotStoreRegistered;

class ProductService
{
    private $productRepo;

    public function __construct(ProductRepo $productRepo)
    {   
        $this->productRepo = $productRepo;
    }

    public function create($name, $description, $price, $user, $url)
    {
        $store = $user->store;

        if(!$store)
            throw new UserNotStoreRegistered('You need register a store for this action!');
            
        $this->productRepo->create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'store_id' => $store->id,
            'url' => $url
        ]);
        return 'Product created!';
    }

    public function getById($id)
    {
        $product = $this->productRepo->findById($id);
        if(!$product)
            throw new ItemNotFound("Product not found");
        return $product;
    }

    public function getAll($query = [])
    {
        $products = $this->productRepo->find(['*'], $query);
        if(!$products)
            throw new ItemNotFound("Products not found");
        return $products;
    }
}