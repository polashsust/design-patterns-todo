<?php

namespace Tests\Unit;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_todo_for_user()
    {
        $user = User::factory()->create();

        $service = app(\App\Services\TodoService::class);

        $dto = new \App\DTOs\TodoDTO(
            $user->id,
            'Sample Todo',
            'A test todo',
            now()->addDay(),
            'offen',
            json_encode(['category_type' => 'WorkTask', 'extra_data' => ['priority' => 'high']])
        );

        $todo = $service->createTodo($dto);

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertEquals('Sample Todo', $todo->title);
        $this->assertEquals($user->id, $todo->user_id);
    }
}
