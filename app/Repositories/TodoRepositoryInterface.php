<?php

namespace App\Repositories;

use App\DTOs\TodoDTO;
use App\Models\Todo;

/**
 * Interface TodoRepositoryInterface
 *
 * Defines the contract for a repository that handles operations related to Todo items.
 * Implementations of this interface should provide methods for creating, retrieving,
 * updating, and deleting Todo entities.
 */
interface TodoRepositoryInterface
{
    public function filteredForUser(int $userId, $category = null, $perPage = 10);

    /**
     * Create a new Todo item.
     *
     * @param TodoDTO $dto
     * @return Todo
     */
    public function create(TodoDTO $dto): Todo;

    /**
     * Update a Todo item.
     *
     * @param Todo $todo
     * @param TodoDTO $dto
     * @return Todo
     */
    public function update(Todo $todo, TodoDTO $dto): Todo;

    /**
     * Delete a Todo item.
     *
     * @param Todo $todo
     * @return void
     */
    public function delete(Todo $todo): void;
}
