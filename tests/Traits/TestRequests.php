<?php

namespace Tests\Traits;

use Database\Factories\UserFactory;
use Illuminate\Testing\TestResponse;

trait TestRequests
{
    protected function tokenRequest(bool $invalid = false): TestResponse
    {
        $user = UserFactory::new()->create([
            'email' => fake()->freeEmail,
            'password' => bcrypt('secret'),
        ]);

        return $this->postJson(route('api.authenticate'), [
            'email' => $user->email,
            'password' => $invalid ? 'password' : 'secret',
        ]);
    }
}
