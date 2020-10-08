<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OpenFoodList extends TestCase
{
    public function testList()
    {
        $response = $this->get('/products');

        $response->dump();
        $response->assertStatus(200);
        $response->assertSeeText('Coca Cola');
        $response->assertSeeText('5449000000996');
    }

    public function testFail()
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertDontSeeText('qwerty');
        $response->assertDontSeeText('5449ssssss996');
    }
}
