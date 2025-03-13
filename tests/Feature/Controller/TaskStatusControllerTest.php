<?php

namespace Tests\Feature\Controller;

use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Database\Factories\TaskStatusFactory;
use Illuminate\Foundation\Testing\WithFaker;

class TaskStatusControllerTest extends TestCase
{
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
}
