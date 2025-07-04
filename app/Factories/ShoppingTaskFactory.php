<?php

namespace App\Factories;

use App\DTOs\TodoDTO;

/**
 * Factory for creating Shopping Task DTOs.
 */
final class ShoppingTaskFactory implements TodoFactoryInterface
{
    /**
     * Create a ShoppingTask TodoDTO.
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
            category_type: 'ShoppingTask',
            extra_data: [
                'estimated_costs' => $data['estimated_costs'] ?? null,
            ]
        );
    }
}
