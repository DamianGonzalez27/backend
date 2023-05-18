<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use App\Models\Product;
use App\Repos\ProductRepo;
use App\Repos\ShoppingCartRepo;
use PHPUnit\Framework\TestCase;
use App\Exceptions\ItemNotFound;
use App\Exceptions\InvalidArgunemt;
use App\Models\ShoppingCart;
use App\Services\ShoppingCartService;

class ShoppingCartServiceTest extends TestCase
{

    protected $shoppingCartRepo;
    protected $productRepo;
    protected $product;
    protected $user;
    protected $service;
    protected $item;

    public function setUp(): void
    {
        parent::setUp();
        $this->shoppingCartRepo = Mockery::mock(ShoppingCartRepo::class);
        $this->productRepo = Mockery::mock(ProductRepo::class);
        $this->product = new Product([
            'id' => 1
        ]);
        $this->user = new User([
            'id' => 123,
            'name' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->item = new ShoppingCart([
            'id' => 1
        ]);
        $this->service = new ShoppingCartService(
            $this->shoppingCartRepo,
            $this->productRepo
        );

    }

    public function testGetAll(): void
    {
        $this->shoppingCartRepo->shouldReceive('find')->once()->andReturn([['id' => 1]]);
        $this->assertEquals(
            [['id' => 1]], 
            $this->service->getAll($this->user)
        );
    }

    public function testUpdateItemNotFound(): void
    {
        $this->productRepo->shouldReceive('findById')->once()->andReturn(null);
        $this->expectException(ItemNotFound::class);
        $this->service->update(1, $this->user);
    }

    public function testUpdateQuantityLessOne(): void
    {
        $this->productRepo->shouldReceive('findById')->once()->andReturn($this->product);
        $this->expectException(InvalidArgunemt::class);
        $this->service->update(1, $this->user, -1);
    }

    public function testUpdateShoppingCartItem(): void
    {
        $this->productRepo->shouldReceive('findById')->once()->andReturn($this->product);   
        $this->shoppingCartRepo->shouldReceive('findFirst')->once()->andReturn($this->item);
        $this->shoppingCartRepo->shouldReceive('updateColumn')->once()->andReturn(true);
        $this->assertEquals(
            'Shopping cart item updated', 
            $this->service->update(1, $this->user, 1)
        );
    }

    public function testCreateShoppingCartItem(): void
    {
        $this->productRepo->shouldReceive('findById')->once()->andReturn($this->product);   
        $this->shoppingCartRepo->shouldReceive('findFirst')->once()->andReturn(null);
        $this->shoppingCartRepo->shouldReceive('create')->once()->andReturn(true);
        $this->assertEquals(
            'Shopping cart item created', 
            $this->service->update(1, $this->user, 1)
        );
    }

    public function testDeleteItem(): void
    {
        $this->shoppingCartRepo->shouldReceive('delete')->once()->andReturn(true);
        $this->assertEquals(
            'Item deleted!',
            $this->service->delete(1)
        );
    }
}