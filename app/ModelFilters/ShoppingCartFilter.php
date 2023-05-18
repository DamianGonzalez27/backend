<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ShoppingCartFilter extends ModelFilter
{
    public $relations = [];

    public function user($user_id)
    {
        return $this->where(function($q) use ($user_id)
        {
            return $q->where('user_id', $user_id);
        });
    }

    public function product($product_id)
    {
        return $this->where(function($q) use ($product_id)
        {
            return $q->where('product_id', $product_id);
        });
    }
}