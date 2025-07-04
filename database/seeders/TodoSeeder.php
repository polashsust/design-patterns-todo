<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'WorkTask',
            'PersonalTask',
            'ShoppingTask',
        ];

        $statuses = [
            'offen',
            'erledigt',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $category = $categories[array_rand($categories)];
            $status = $statuses[array_rand($statuses)];
            $title = Str::title(fake()->words(2, true));
            $description = fake()->sentence(8);
            $dueDate = now()->addDays(rand(1, 30))->format('Y-m-d');

            // Extra data by category
            $extra = [];
            if ($category === 'WorkTask') {
                $extra = ['priority' => fake()->randomElement(['High', 'Normal', 'Low'])];
            } elseif ($category === 'PersonalTask') {
                $extra = ['mood' => fake()->randomElement(['Happy', 'Motivated', 'Tired', 'Relaxed'])];
            } else {
                $extra = ['estimated_costs' => rand(10, 200)];
            }

            Todo::create([
                'user_id' => 1, // Change if you want to assign to a different user
                'title' => $title,
                'description' => $description,
                'due_date' => $dueDate,
                'status' => $status,
                'category_type' => $category,
                'extra_data' => $extra,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
