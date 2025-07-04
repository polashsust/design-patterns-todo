<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_todo()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('todos.store'), [
            'title' => 'My Test Todo',
            'description' => 'Test Desc',
            'due_date' => now()->addDays(2)->toDateString(),
            'status' => 'offen',
            'category_type' => 'PersonalTask',
            'extra_data' => ['mood' => 'happy'],
        ]);

        $response->assertRedirect(route('todos.index'));
        $this->assertDatabaseHas('todos', [
            'title' => 'My Test Todo',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_edit_others_todo()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $todo = Todo::factory()->for($other)->create([
            'title' => 'Other User Todo',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('todos.update', $todo), [
            'title' => 'Hacked Title',
            'description' => 'Should not update',
            'due_date' => now()->addDay()->toDateString(),
            'status' => 'offen',
            'category_type' => 'WorkTask',
            'extra_data' => [],
        ]);

        $response->assertForbidden();
    }

    public function test_todos_are_visible_on_index()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create(['title' => 'Visible Todo']);
        $this->actingAs($user);

        $response = $this->get(route('todos.index'));
        $response->assertOk();
        $response->assertSee('Visible Todo');
    }
}
