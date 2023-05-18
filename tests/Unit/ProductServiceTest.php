<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use App\Models\Store;
use App\Repos\ProductRepo;
use PHPUnit\Framework\TestCase;
use App\Exceptions\ItemNotFound;
use App\Services\ProductService;
use App\Exceptions\UserNotStoreRegistered;

class ProductServiceTest extends TestCase
{

    protected $productRepo;
    protected $user;
    protected $service;
    protected $store;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepo = Mockery::mock(ProductRepo::class);
        $this->user = Mockery::mock(User::class)->makePartial();
        $this->store = new Store(
            ['id' => 1]
        );
        $this->service = new ProductService($this->productRepo);
    }

    public function testCreateUserNotRegister(): void
    {
        $this->user->store = null;
        $this->expectException(UserNotStoreRegistered::class);
        $this->service->create('', '', '', $this->user, '');
    }

    public function testCreateSuccess(): void
    {
        $this->user->store = $this->store;
        $this->productRepo->shouldReceive('create')->once()->andReturn(true);
        $this->assertEquals(
            'Product created!',
            $this->service->create('name', 'description', '102', $this->user, 'url')
        );
    }

    public function testGetByIdNotFound(): void
    {
        $this->productRepo->shouldReceive('findById')->once()->andReturn(null);
        $this->expectException(ItemNotFound::class);
        $this->service->getById(1);
    }

    public function testgetByIdFounded(): void
    {
        $this->productRepo->shouldReceive('findById')->once()->andReturn(["id" => 1]);
        $this->assertEquals(['id' => 1], $this->service->getById(1));
    }

    public function testGetAllNotFound(): void
    {
        $this->productRepo->shouldReceive('find')->once()->andReturn(null);
        $this->expectException(ItemNotFound::class);
        $this->service->getAll(1);
    }

    public function testGetAllSuccess(): void
    {
        $this->productRepo->shouldReceive('find')->once()->andReturn([['id' => 1]]);
        $this->assertEquals([['id' => 1]], $this->service->getAll());
    }

    
}