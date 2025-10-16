<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_the_application_can_get_tasks(): void
    {
        $user = User::factory()->create();
        $auth = $this->actingAsJwtUser();
        $response = $this->withHeaders($auth['headers'])->get('api/tasks');

        $response->assertStatus(200);
    }

    public function test_the_application_can_get_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);
        $auth = $this->actingAsJwtUser();
        $response = $this->withHeaders($auth['headers'])->get('api/tasks/' . $task->id);

        $response->assertStatus(200);
    }

    public function test_the_application_can_store_a_task(): void
    {
        $user = User::factory()->create();
        $auth = $this->actingAsJwtUser();
        $response = $this->withHeaders($auth['headers'])->post('api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(7),
        ]);

        $response->assertStatus(201);
    }

    public function test_the_application_can_update_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);
        $auth = $this->actingAsJwtUser();
        $response = $this->withHeaders($auth['headers'])->put('api/tasks/' . $task->id, [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(7),
        ]);

        $response->assertStatus(200);
    }

    public function test_the_application_can_delete_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);
        $auth = $this->actingAsJwtUser();
        $response = $this->withHeaders($auth['headers'])->delete('api/tasks/' . $task->id);

        $response->assertStatus(204);
    }

    public function test_the_application_doesnt_allow_unauthenticated_users_to_access_tasks(): void
    {
        $response = $this->get('api/tasks');

        $response->assertStatus(401);
    }

    public function test_the_application_doesnt_allow_unauthenticated_users_to_store_a_task(): void
    {
        $user = User::factory()->create();
        $response = $this->post('api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(7),
        ]);

        $response->assertStatus(401);
    }

    public function test_the_application_doesnt_allow_unauthenticated_users_to_update_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);
        
        $response = $this->put('api/tasks/' . $task->id, [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(7),
        ]);

        $response->assertStatus(401);
    }

    public function test_the_application_doesnt_allow_unauthenticated_users_to_delete_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);
        $auth = $this->actingAsJwtUser();
        $response = $this->withHeaders($auth['headers'])->delete('api/tasks/' . $task->id);

        $response->assertStatus(401);
    }
}
