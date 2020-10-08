<?php

namespace Tests\Unit;

use App\Services\ProductsService;
use PHPUnit\Framework\TestCase;

class ProductService extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCount()
    {
        /** @var ProductsService $service */
        $service = resolve(ProductService::class);
        $this->assertCount(20, $service->getOpenFoodList(1)->getItems());
    }
}
