<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\TaskComment;

class TaskCommentTest extends TestCase
{
    use RefreshDatabase;
    public function test_the_application_can_comment_on_a_task(): void
    {
        $auth = $this->actingAsJwtUser();
        $user = $auth['user'];

        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);

        $response = $this->post('/api/comments', [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'comment' => 'test comment',
        ], $auth['headers'])->assertStatus(201);

        $response->assertStatus(201);
    }

    public function test_the_application_can_update_a_comment(): void
    {
        $auth = $this->actingAsJwtUser();
        $user = $auth['user'];

        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);

        $comment = TaskComment::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'comment' => 'test comment',
        ]);

        $response = $this->put('/api/comments/' . $comment->id, [
            'task_id' => $task->id,
            'comment' => 'test comment',
        ], $auth['headers'])->assertStatus(200);
    }

    public function test_the_application_can_delete_a_comment(): void
    {
        $auth = $this->actingAsJwtUser();
        $user = $auth['user'];

        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);

        $comment = TaskComment::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'comment' => 'test comment',
        ]);

        $response = $this->withHeaders($auth['headers'])->delete('/api/comments/' . $comment->id)->assertStatus(204);
    }
}
