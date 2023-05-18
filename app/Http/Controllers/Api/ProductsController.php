<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;

class ProductsController extends Controller
{
    private $producService;

    public function __construct(ProductService $producService)
    {
        $this->producService = $producService;
    }

    public function index()
    {
        return $this->responseWhidthData(
            'products', 
            $this->producService->getAll()
        );
    }

    public function show($id)
    {
        return $this->responseWhidthData(
            'product', 
            $this->producService->getById($id)
        );
    }

    public function create(CreateProductRequest $request)
    {
        return $this->basicResponse(
            $this->producService->create(
                $request->input('name'),
                $request->input('description'),
                $request->input('price'),
                $request['user'],
                $request->input('url')
            )
        );
    }

    public function myProducts(Request $request)
    {
        return $this->responseWhidthData(
            'my-products', 
            $this->producService->getAll(['store' => $request['user']->store->id])
        );
    }

}
