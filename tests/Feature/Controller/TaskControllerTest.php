<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->task = Task::factory()->create([
            'created_by_id' => $this->user->id,
        ]);
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertStatus(200);
    }

    public function testCreatePage()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $taskData = Task::factory()->make()->toArray();

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['name' => $taskData['name']]);
    }

    public function testGuestCannotCreate()
    {
        $response = $this->post(route('tasks.store'), []);
        $response->assertRedirect(route('login'));
    }

    public function testEdit()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertStatus(200);
    }

    public function testGuestCannotEdit()
    {
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertRedirect(route('login'));
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);
        $newData = [
            'name' => 'Updated Task Name',
            'description' => 'New Description',
            'status_id' => $this->task->status_id,
            'assigned_to_id' => $this->task->assigned_to_id
        ];

        $response = $this->patch(route('tasks.update', $this->task), $newData);
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', ['id' => $this->task->id, 'name' => 'Updated Task Name']);
    }

    public function testDelete()
    {
        $this->actingAs($this->user);
        $response = $this->delete(route('tasks.destroy', $this->task));

        $response->assertRedirect();
        $this->assertSoftDeleted($this->task);
    }

    public function testNonCreatorCannotDelete()
    {
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        $response = $this->delete(route('tasks.destroy', $this->task));

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
    }

    public function testGuestCannotDelete()
    {
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
        $response = $this->delete(route('tasks.destroy', $this->task));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
    }
}
