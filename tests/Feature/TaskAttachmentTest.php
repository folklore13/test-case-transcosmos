<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_the_application_can_attach_a_file_to_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);

        Storage::fake('public');
        $response = $this->actingAs($user)->post('/api/tasks/' . $task->id . '/attachments', [
            'file' => 'test.jpg',
        ]);

        $response->assertStatus(200);
    }


}
