<?php

namespace App\Http\Controllers\Api;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\TestRequests;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;
    use TestRequests;

    /**
     * @test
     * @return void
     */
    public function it_successful_added_to_cart(): void
    {
        $response = $this->tokenRequest();
        $token = $response->json('data.id');

        $product = ProductFactory::new()->create();

        $this->withToken($token)->postJson(
            route('api.cart.add', $product->getKey())
        )->assertCreated();

        $response = $this->withToken($token)->getJson(
            route('api.cart.index')
        );

        $response->assertJsonIsArray('data')
            ->assertJsonStructure([
                'data' => [
                    ['id', 'type', 'attributes']
                ]
            ]);

        $this->assertEquals($product->getKey(), $response->json('data.0.id'));
    }
}
