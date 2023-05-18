<?php

namespace App\Http\Controllers\Api;

use App\Services\StoreService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStoreRequest;

class StoreController extends Controller
{
    private $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function show($id)
    {
        return $this->responseWhidthData(
            'Store',
            $this->storeService->getById($id)
        );
    }

    public function create(CreateStoreRequest $request)
    {
        return $this->responseWhidthData(
            'Store Create',
            $this->storeService->create(
                $request->input('name'),
                $request->input('description'),
                $request['user']
            )
        );
    }
}
