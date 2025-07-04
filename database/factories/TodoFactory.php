<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory class for creating Todo model instances for testing and seeding.
 *
 * This factory defines the default state for the Todo model, allowing
 * for the generation of fake data for testing and database seeding purposes.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('+1 day', '+2 weeks'),
            'status' => $this->faker->randomElement(['offen', 'erledigt']),
            'category_type' => $this->faker->randomElement(['WorkTask', 'PersonalTask', 'ShoppingTask']),
            'extra_data' => ['priority' => $this->faker->randomElement(['high', 'medium', 'low'])],
        ];
    }
}
