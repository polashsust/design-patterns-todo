<?php

namespace App\Factories;

use App\Factories\WorkTaskFactory;
use App\Factories\PersonalTaskFactory;
use App\Factories\ShoppingTaskFactory;

/**
 * Abstract Factory for creating Todo category-specific factories.
 */
final class TodoCategoryAbstractFactory
{
    /**
     * Create a category-specific TodoFactory.
     *
     * @param string $type The category type.
     * @return TodoFactoryInterface
     * @throws \InvalidArgumentException If the category type is unknown.
     */
    public static function make(string $type): TodoFactoryInterface
    {
        return match ($type) {
            'WorkTask'      => new WorkTaskFactory(),
            'PersonalTask'  => new PersonalTaskFactory(),
            'ShoppingTask'  => new ShoppingTaskFactory(),
            default         => throw new \InvalidArgumentException("Unknown category type: {$type}"),
        };
    }
}
