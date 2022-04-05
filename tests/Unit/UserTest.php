<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_login()
    {
        $response = $this->json('POST', '/api/login', ['email' => 'utest@gmail.com', 'password' => 'testlocal', 'app_name' => 'test_name']);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'name',
                'roles' => ['*' => ['name']],
                'token',
            ]);
    }

    public function test_user_login_failed()
    {
        $response = $this->json('POST', '/api/login', ['email' => 'utest@gmail.com', 'password' => 'badlocal', 'app_name' => 'test_name']);
        $response->assertStatus(422);
    }

    public function test_user_logout()
    {
        $login_response = $this->json('POST', '/api/login', ['email' => 'utest@gmail.com', 'password' => 'testlocal', 'app_name' => 'test_name'])
            ->decodeResponseJson();
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $login_response['token']])
            ->json('POST', '/api/logout', ['app_name' => 'test_name']);
        $response->assertStatus(200);
    }
}
