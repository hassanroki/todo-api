<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test Description',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                 ->assertJson($data);
    }

    public function test_can_list_tasks()
    {
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_can_show_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200)
                 ->assertJson($task->toArray());
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'is_completed' => true,
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $data);

        $response->assertStatus(200)
                 ->assertJson($data);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(204);
    }
}
