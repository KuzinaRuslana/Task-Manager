<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Label;
use App\Models\User;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
    }

    public function testCreatePageIsAccessibleForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('labels.create'));
        $response->assertStatus(200);
    }

    public function testGuestCannotAccessCreatePage()
    {
        $response = $this->get(route('labels.create'));
        $response->assertRedirect(route('login'));
    }

    public function testStore()
    {
        $this->actingAs($this->user);
        $data = Label::factory()->make()->toArray();

        $response = $this->post(route('labels.store'), $data);

        $this->assertDatabaseHas('labels', $data);
        $response->assertRedirect(route('labels.index'));
    }

    public function testGuestCannotStoreLabel()
    {
        $data = Label::factory()->make()->toArray();

        $response = $this->post(route('labels.store'), $data);

        $this->assertDatabaseMissing('labels', $data);
        $response->assertRedirect(route('login'));
    }

    public function testEditPageIsAccessibleForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertStatus(200);
    }

    public function testGuestCannotAccessEditPage()
    {
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertRedirect(route('login'));
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);
        $data = ['name' => 'Updated Name', 'description' => 'Updated Description'];

        $response = $this->patch(route('labels.update', $this->label), $data);

        $this->assertDatabaseHas('labels', $data);
        $response->assertRedirect(route('labels.index'));
    }

    public function testGuestCannotUpdateLabel()
    {
        $oldData = $this->label->only(['name', 'description']);
        $newData = ['name' => 'New Name', 'description' => 'New Description'];

        $this->patch(route('labels.update', $this->label), $newData);

        $this->assertDatabaseHas('labels', $oldData);
        $this->assertDatabaseMissing('labels', $newData);
    }

    public function testDestroy()
    {
        $this->actingAs($this->user);

        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);

        $response = $this->delete(route('labels.destroy', $this->label));

        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
        $response->assertRedirect(route('labels.index'));
    }

    public function testGuestCannotDeleteLabel()
    {
        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);

        $this->delete(route('labels.destroy', $this->label));

        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }
}
