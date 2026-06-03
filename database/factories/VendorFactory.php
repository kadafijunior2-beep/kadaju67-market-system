<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        $businessTypes = ['retail', 'wholesale', 'food', 'textile', 'electronics', 'crafts', 'services'];

        return [
            'full_name' => fake()->name(),
            'phone' => '0' . fake()->numberBetween(700000000, 799999999),
            'email' => fake()->unique()->safeEmail(),
            'national_id' => fake()->unique()->numerify('##########'),
            'business_type' => fake()->randomElement($businessTypes),
            'address' => fake()->address(),
            'registration_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive', 'suspended']),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
