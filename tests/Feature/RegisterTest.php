<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    // visit the register page
    public function test_can_visit_page(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_can_register(): void
    {
        // refresh the database

        $response = $this->post('/register', [
            'name' => 'test_name',
            'email' => 'test_email@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            '_token' => csrf_token(),
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'name' => 'test_name',
            'email' => 'test_email@example.com',
        ]);
    }

    public function test_invalid_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'test_name2',
            'email' => 'email',
            'password' => 'password',
            'password_confirmation' => 'password',
            '_token' => csrf_token(),
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'test_name2',
            'email' => 'email',
        ]);
        $response->assertRedirect('/');
        $response->assertStatus(302);
    }

    public function test_invalid_password(): void
    {
        $this->post('/register', [
            'name' => 'test_name3',
            'email' => 'test_email3@example.com',
            'password' => '123',
            'password_confirmation' => '123',
            '_token' => csrf_token(),
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => 'test_name3',
            'email' => 'test_email3@example.com',
        ]);
    }
}
