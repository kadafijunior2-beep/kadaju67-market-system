<?php

namespace Database\Factories;

use App\Models\Stall;
use Illuminate\Database\Eloquent\Factories\Factory;

class StallFactory extends Factory
{
    protected $model = Stall::class;

    public function definition(): array
    {
        $locations = ['Section A', 'Section B', 'Section C', 'Main Hall', 'East Wing', 'West Wing', 'North Wing', 'South Wing'];
        $sizes = ['Small (3x3)', 'Medium (4x4)', 'Large (6x4)', 'Extra Large (8x4)'];

        return [
            'stall_number' => 'STL-' . fake()->unique()->bothify('####'),
            'location' => fake()->randomElement($locations),
            'size' => fake()->randomElement($sizes),
            'monthly_rent' => fake()->randomElement([50000, 75000, 100000, 150000, 200000]),
            'status' => fake()->randomElement(['available', 'occupied', 'occupied', 'available', 'maintenance']),
            'description' => fake()->sentence(),
        ];
    }

    public function available(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'available',
        ]);
    }

    public function occupied(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'occupied',
        ]);
    }
}
