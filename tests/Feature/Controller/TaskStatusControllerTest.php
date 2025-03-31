<?php

namespace Tests\Feature\Controller;

use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(200);
    }

    public function testGuestCannotCreate()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertRedirect(route('login'));
    }

    public function testStore()
    {
        $this->actingAs($this->user);

        $data = ['name' => 'New Status'];
        $response = $this->post(route('task_statuses.store'), $data);

        $this->assertDatabaseHas('task_statuses', $data);
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testGuestCannotStore()
    {
        $data = ['name' => 'New Status'];
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('login'));
    }

    public function testEdit()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertStatus(200);
    }

    public function testGuestCannotEdit()
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertRedirect(route('login'));
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);
        $data = ['name' => 'Updated Status'];

        $response = $this->patch(route('task_statuses.update', $this->taskStatus), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id, 'name' => 'Updated Status']);
    }

    public function testGuestCannotUpdate()
    {
        $data = ['name' => 'Updated Status'];
        $response = $this->patch(route('task_statuses.update', $this->taskStatus), $data);
        $response->assertRedirect(route('login'));
    }


    public function testDelete()
    {
        $this->actingAs($this->user);
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }

    public function testGuestCannotDelete()
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertRedirect(route('login'));
    }

    public function testCannotBeDeletedIfUsed()
    {
        $this->actingAs($this->user);
        Task::factory()->create(['status_id' => $this->taskStatus->id]);

        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
