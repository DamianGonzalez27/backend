<?php
namespace App\Repos;

use App\Models\ShoppingCart;
use App\Repos\RepoBase;

class ShoppingCartRepo extends RepoBase
{
    public function __construct(ShoppingCart $shoppingCart)
    {
        parent::__construct($shoppingCart);
    }

    public function create($data)
    {
        return ShoppingCart::insertGetId($data);
    }
}