<?php

namespace App\Repositories;

use App\DTOs\TodoDTO;
use App\Models\Todo;

class EloquentTodoRepository implements TodoRepositoryInterface
{
    /**
     * Retrieves a paginated and optionally filtered list of todos for a specific user.
     *
     * @param  int  $userId  The ID of the user whose todos are to be retrieved.
     * @param  mixed  $category  (Optional) The category to filter todos by. Defaults to null (no category filter).
     * @param  int  $perPage  (Optional) The number of results per page for pagination. Defaults to 10.
     * @param  string  $sortBy  (Optional) The column to sort the results by. Defaults to 'id'.
     * @param  string  $sortDir  (Optional) The direction to sort the results ('asc' or 'desc'). Defaults to 'desc'.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of todos matching the criteria.
     */
    public function filteredForUser(
        int $userId,
        $category = null,
        $perPage = 10,
        $sortBy = 'id',
        $sortDir = 'desc'
    ) {
        $query = Todo::where('user_id', $userId);

        if ($category) {
            $query->where('category_type', $category);
        }

        // Basic allowed fields check for security
        $allowedSorts = ['id', 'created_at', 'due_date'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'id';
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    /**
     * Creates a new Todo item based on the provided data transfer object.
     *
     * @param  TodoDTO  $dto  Data transfer object containing the details for the new Todo.
     * @return Todo The newly created Todo instance.
     */
    public function create(TodoDTO $dto): Todo
    {
        return Todo::create([
            'user_id' => $dto->user_id,
            'title' => $dto->title,
            'description' => $dto->description,
            'due_date' => $dto->due_date,
            'status' => $dto->status,
            'category_type' => $dto->category_type,
            'extra_data' => $dto->extra_data,
        ]);
    }

    /**
     * Updates the given Todo model with data from the provided TodoDTO.
     *
     * @param  Todo  $todo  The Todo model instance to update.
     * @param  TodoDTO  $dto  The data transfer object containing updated data.
     * @return Todo The updated Todo model instance.
     */
    public function update(Todo $todo, TodoDTO $dto): Todo
    {
        $todo->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'due_date' => $dto->due_date,
            'status' => $dto->status,
            'category_type' => $dto->category_type,
            'extra_data' => $dto->extra_data,
        ]);

        return $todo;
    }

    /**
     * Deletes the specified Todo item from the data source.
     *
     * @param  Todo  $todo  The Todo instance to be deleted.
     */
    public function delete(Todo $todo): void
    {
        $todo->delete();
    }
}
