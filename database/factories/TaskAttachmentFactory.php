<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskAttachment>
 */
class TaskAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'file_name' => fake()->word(),
            'file_path' => fake()->imageUrl(),
            'file_size' => fake()->randomNumber(5),
            'mime_type' => fake()->randomElement(['image', 'video', 'document']),
        ];
    }
}
