<?php
namespace App\Repos;

use App\Models\Store;
use App\Repos\RepoBase;

class StoreRepo extends RepoBase
{
    public function __construct(Store $store)
    {
        parent::__construct($store);
    }

    public function create($data)
    {
        return Store::insertGetId($data);
    }
}