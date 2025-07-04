<?php

namespace App\Factories;

use App\DTOs\TodoDTO;

/**
 * Factory for creating Work Task DTOs.
 */
final class WorkTaskFactory implements TodoFactoryInterface
{
    /**
     * Create a WorkTask TodoDTO.
     *
     * @param array $data  The data to populate the DTO.
     * @return TodoDTO
     */
    public function create(array $data): TodoDTO
    {
        return new TodoDTO(
            user_id: $data['user_id'],
            title: $data['title'],
            description: $data['description'] ?? '',
            due_date: $data['due_date'],
            status: $data['status'],
            category_type: 'WorkTask',
            extra_data: [
                'priority' => $data['priority'] ?? null,
            ]
        );
    }
}
