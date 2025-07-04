<?php

namespace App\DTOs;

/**
 * Data Transfer Object for Todo creation and updates.
 *
 * @property-read int $user_id
 * @property-read string $title
 * @property-read string $description
 * @property-read string $due_date
 * @property-read string $status
 * @property-read string $category_type
 * @property-read array $extra_data
 */
class TodoDTO
{
    /**
     * @param int $user_id             The ID of the user who owns the todo.
     * @param string $title            The title of the todo.
     * @param string $description      The description of the todo.
     * @param string $due_date         The due date (ISO 8601 string or Y-m-d format).
     * @param string $status           The status ('offen', 'erledigt', etc.).
     * @param string $category_type    The type/category of the todo.
     * @param array $extra_data        Extra data fields as associative array.
     */
    public function __construct(
        public readonly int $user_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $due_date,
        public readonly string $status,
        public readonly string $category_type,
        public readonly array $extra_data = [],
    ) {}
}
