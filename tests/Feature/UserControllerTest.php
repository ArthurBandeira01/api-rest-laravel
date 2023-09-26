<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Factories\UserFactory;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions; // ou RefreshDatabase se preferir usar um banco de dados em memória
    use WithFaker;

    public function testIndex()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->post('/users', $data);

        $response->assertStatus(201);
    }

    public function testShow()
    {
        $user = UserFactory::new()->create();

        $response = $this->get("/users/{$user->id}");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = UserFactory::new()->create();

        $newData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'newpassword123'
        ];

        $response = $this->put("/users/{$user->id}", $newData);
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $user = UserFactory::new()->create();

        $response = $this->delete("/users/{$user->id}");

        $response->assertStatus(204);
    }
}
