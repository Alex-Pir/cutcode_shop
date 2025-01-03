<?php

namespace App\Http\Controllers\Api;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\TestRequests;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;
    use TestRequests;

    /**
     * @test
     * @return void
     */
    public function it_successful_index_response(): void
    {
        $token = $this->tokenRequest()->json('data.id');

        ProductFactory::new()->count(10)->create();

        $this->withToken($token)->getJson(
            route('api.catalog.index')
        );
    }
}
