<?php

namespace App\Services;

use App\DTOs\TodoDTO;
use App\Repositories\TodoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Service class responsible for handling business logic related to Todo items.
 * Provides methods for creating, retrieving, updating, and deleting todos.
 */
class TodoService
{
    /**
     * Inject the TodoRepository dependency.
     *
     * @param TodoRepositoryInterface $repo
     */
    public function __construct(
        protected readonly TodoRepositoryInterface $repo
    ) {}

    /**
     * Retrieves a paginated and optionally filtered list of todos for a specific user.
     *
     * @param  int $userId      The ID of the user whose todos are to be retrieved.
     * @param  string|null $category  (Optional) The category to filter todos by.
     * @param  int $perPage     (Optional) The number of todos per page for pagination.
     * @param  string $sortBy   (Optional) The field to sort the todos by.
     * @param  string $sortDir  (Optional) The direction to sort the todos ('asc' or 'desc').
     * @return LengthAwarePaginator    Paginated list of filtered todos.
     */
    public function filteredTodos(
        int $userId,
        ?string $category = null,
        int $perPage = 10,
        string $sortBy = 'id',
        string $sortDir = 'desc'
    ): LengthAwarePaginator {
        return $this->repo->filteredForUser($userId, $category, $perPage, $sortBy, $sortDir);
    }

    /**
     * Creates a new todo item based on the provided data transfer object.
     *
     * @param  TodoDTO  $dto  Data transfer object containing the details of the todo item to be created.
     * @return mixed          The result of the todo creation process, typically the created todo item.
     */
    public function createTodo(TodoDTO $dto): mixed
    {
        return $this->repo->create($dto);
    }
}
