<?php
namespace App\Services;

use App\Exceptions\InvalidArgunemt;
use App\Repos\ProductRepo;
use App\Repos\ShoppingCartRepo;
use App\Exceptions\ItemNotFound;

class ShoppingCartService
{
    private $shoppingCartRepo;
    private $productRepo;

    public function __construct(ShoppingCartRepo $shoppingCartRepo, ProductRepo $productRepo)
    {
        $this->shoppingCartRepo = $shoppingCartRepo;    
        $this->productRepo = $productRepo;
    }

    public function getAll($user)
    {
        return $this->shoppingCartRepo->find(['*'], ['user' => $user->id]);
    }

    public function update($product_id, $user, $quantity = 1)
    {
        $product = $this->productRepo->findById($product_id);

        if(!$product)
            throw new ItemNotFound('Product not fount');

        if($quantity < 1)
            throw new InvalidArgunemt('The quantity need be more to 0');

        $shoppongItem = $this->shoppingCartRepo->findFirst(['*'], ['product' => $product_id, 'user' => $user->id]);

        if(!$shoppongItem){    
            $this->shoppingCartRepo->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);

            return "Shopping cart item created";
        }
        else 
        {
            $this->shoppingCartRepo->updateColumn($shoppongItem->id, ['quantity' => $quantity]);
            return "Shopping cart item updated";
        }
    }

    public function delete($id)
    {
        $this->shoppingCartRepo->delete($id);
        return "Item deleted!";
    }
}