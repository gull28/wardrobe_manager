<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    // visit the register page
    public function test_can_visit_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_can_valid_login(): void

        $user = User::factory()->create();
        // create user to login with
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/wardrobe');
       
    }
}
