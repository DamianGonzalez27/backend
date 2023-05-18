<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StoreFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function user($user_id)
    {
        return $this->where(function($q) use ($user_id)
        {
            return $q->where('user_id', $user_id);
        });
    }
}
