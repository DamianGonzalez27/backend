<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use App\Repos\StoreRepo;
use App\Services\StoreService;
use App\Exceptions\StoreExists;
use PHPUnit\Framework\TestCase;
use App\Exceptions\ItemNotFound;

class StoreServiceTest extends TestCase
{
    protected $storeRepo;
    protected $storeService;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->storeRepo = Mockery::mock(StoreRepo::class);
        $this->storeService = new StoreService($this->storeRepo);
        $this->user = new User([
            'id' => 123,
            'name' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
    }

    public function testGetByIdItemNotFound(): void
    {
        $this->storeRepo->shouldReceive('findById')->once()->andReturn(null);
        $this->expectException(ItemNotFound::class);
        $this->storeService->getById(1);
    }

    public function testGetByIdSuccess(): void
    {
        $this->storeRepo->shouldReceive('findById')->once()->andReturn(['id' => 1]);
        $this->assertEquals(
            ['id' => 1],
            $this->storeService->getById(1)
        );
    }

    public function testCreateExists(): void
    {
        $this->storeRepo->shouldReceive('findFirst')->once()->andReturn(true);
        $this->expectException(StoreExists::class);
        $this->storeService->create('', '', $this->user);
    }

    public function testCreate(): void
    {
        $this->storeRepo->shouldReceive('create')->once()->andReturn(['id' => 1]);
        $this->storeRepo->shouldReceive('findFirst')->once()->andReturn(false);
        $this->assertEquals(
            'Store created!',
            $this->storeService->create('', '', $this->user)
        );
    }

}
