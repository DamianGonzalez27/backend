<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function name($name)
    {
        return $this->where(function($q) use ($name)
        {
            return $q->where('name', $name);
        });
    }

    public function description($description)
    {
        return $this->where(function($q) use ($description)
        {
            return $q->where('description', $description);
        });
    }

    public function store($store_id)
    {
        return $this->where(function($q) use ($store_id)
        {
            return $q->where('description', $store_id);
        });
    }
}
