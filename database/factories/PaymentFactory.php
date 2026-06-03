<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $methods = ['cash', 'bank_transfer', 'mobile_money', 'check'];

        return [
            'vendor_id' => Vendor::factory(),
            'amount' => fake()->randomFloat(2, 10000, 500000),
            'payment_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'payment_method' => fake()->randomElement($methods),
            'reference_number' => 'PAY-' . fake()->unique()->bothify('########'),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement(['completed', 'completed', 'completed', 'pending', 'failed']),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed',
        ]);
    }
}
