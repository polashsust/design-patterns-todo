<?php

namespace App\Http\Controllers;

use App\Factories\TodoCategoryAbstractFactory;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

/**
 * Controller responsible for CRUD operations on Todo items.
 */
class TodoController extends Controller
{
    public function __construct(
        protected readonly TodoService $service
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the todo items.
     */
    public function index(\Illuminate\Http\Request $request): InertiaResponse
    {
        $todos = $this->service->filteredTodos(
            $request->user()->id,
            $request->query('category'),
            10,
            $request->query('sort_by', 'id'),
            $request->query('sort_dir', 'desc')
        );

        return Inertia::render('Todos/Index', [
            'todos' => $todos,
            'filters' => [
                'category' => $request->query('category'),
                'sort_by'  => $request->query('sort_by', 'id'),
                'sort_dir' => $request->query('sort_dir', 'desc'),
            ],
        ]);
    }

    /**
     * Store a newly created todo item in storage.
     */
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $factory = TodoCategoryAbstractFactory::make($data['category_type']);
        $dto = $factory->create([
            ...$data,
            'user_id'    => $request->user()->id,
            ...($data['extra_data'] ?? []),
        ]);

        $this->service->createTodo($dto);

        return redirect()->route('todos.index');
    }

    /**
     * Update the specified todo item in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $data = $request->validated();

        $todo->update([
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'due_date'      => $data['due_date'],
            'status'        => $data['status'],
            'category_type' => $data['category_type'],
            'extra_data'    => $data['extra_data'] ?? [],
        ]);

        return redirect()->route('todos.index')->with('todo', $todo->fresh());
    }

    /**
     * Remove the specified todo item from storage.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully!');
    }
}
