<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskAttachmentTest extends TestCase
{
    use RefreshDatabase;
    public function test_the_application_can_attach_a_file_to_a_task(): void
    {
        Storage::fake('public');
        $auth = $this->actingAsJwtUser();
        $user = $auth['user'];

        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post('/api/tasks/' . $task->id . '/attachments', [
            'file' => $file,
        ], $auth['headers'])->assertStatus(201);

        Storage::disk('public')->assertExists($file->hashName());
    }

    public function test_the_application_can_download_a_file_from_a_task(){
        Storage::fake('public');
        $auth = $this->actingAsJwtUser();
        $user = $auth['user'];

        $task = Task::factory()->create([
            'assigned_user_id' => $user->id,
            'created_by_user_id' => $user->id,
        ]);

        $file = UploadedFile::fake()->image('test.jpg');

        Storage::disk('public')->assertExists($file->hashName());

        $response = $this->get('/api/tasks/' . $task->id . '/attachments', $auth['headers'])->assertStatus(200);
    }
}
