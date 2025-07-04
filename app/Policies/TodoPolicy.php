<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

/**
 * Policy class for handling authorization logic related to Todo model actions.
 *
 * Defines methods to determine if a user is authorized to perform
 * specific actions (such as view, create, update, or delete) on Todo items.
 */
class TodoPolicy
{
    /**
     * Determine whether the user can view the specified todo item.
     *
     * @param User $user  The user attempting to view the todo item.
     * @param Todo $todo  The todo item being viewed.
     * @return bool       True if the user can view the todo item, false otherwise.
     */
    public function view(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the specified todo item.
     *
     * @param User $user  The user attempting to update the todo item.
     * @param Todo $todo  The todo item to be updated.
     * @return bool       True if the user can update the todo, false otherwise.
     */
    public function update(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the specified todo item.
     *
     * @param User $user  The user attempting to delete the todo item.
     * @param Todo $todo  The todo item to be deleted.
     * @return bool       True if the user can delete the todo, false otherwise.
     */
    public function delete(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }

    /**
     * Determine whether the user can create a new Todo item.
     *
     * @param User $user  The user attempting to create the Todo.
     * @return bool       True if the user is authorized to create the Todo, false otherwise.
     */
    public function create(User $user): bool
    {
        // You can add more logic if needed, e.g. user must be active, verified, etc.
        return true;
    }
}
