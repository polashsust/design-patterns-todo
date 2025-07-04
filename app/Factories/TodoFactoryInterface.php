<?php

namespace App\Factories;

use App\DTOs\TodoDTO;

/**
 * Interface for Todo category factories.
 * Ensures a standard contract for creating TodoDTO instances.
 */
interface TodoFactoryInterface
{
    /**
     * Create a TodoDTO from given data.
     *
     * @param array $data The input data for the DTO.
     * @return TodoDTO
     */
    public function create(array $data): TodoDTO;
}
