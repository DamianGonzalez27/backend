<?php
namespace App\Services;

use App\Repos\StoreRepo;
use App\Exceptions\ItemNotFound;
use App\Exceptions\StoreExists;

class StoreService
{
    private $storeRepo;

    public function __construct(StoreRepo $storeRepo)
    {
        $this->storeRepo = $storeRepo;
    }

    public function getById($id)
    {
        $store = $this->storeRepo->findById($id);
        
        if(!$store)
            throw new ItemNotFound('Store not found!');
        
        return $store;
    }

    public function create($name, $description, $user)
    {
        if($this->storeRepo->findFirst(['id'], ['user' => $user->id]))
            throw new StoreExists('Store already exists');

        $this->storeRepo->create([
            'name' => $name,
            'description' => $description,
            'user_id' => $user->id
        ]);

        return "Store created!";
    }
}