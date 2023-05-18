<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ShoppingCartService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateShoppingCartRequest;

class ShoppingCartController extends Controller
{
    private $shoppingCartService;

    public function __construct(ShoppingCartService $shoppingCartService)
    {
        $this->shoppingCartService = $shoppingCartService;
    }

    public function index(Request $request)
    {
        $items = $this->shoppingCartService->getAll($request['user']);
        $response = [];
        foreach($items as $item){
            $response[] = $item->product;
        }
        return $this->responseWhidthData(
            'ShoppingCart',
            $response
        );
    }

    public function update(UpdateShoppingCartRequest $request, $product_id)
    {
        return $this->basicResponse(
            $this->shoppingCartService->update($product_id, $request['user'], $request->input('quantity'))
        );
    }

    public function delete($id)
    {
        return $this->basicResponse(
            $this->shoppingCartService->delete($id)
        );
    }

}
