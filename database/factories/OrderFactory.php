<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PickupPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    static $i = 1;
        return [
            'user_id' => $i++,
            'pickup_points_id' => 10,
            'payment_method' => 'cash',
            'payment_status' => $this->faker->boolean(),

            // 'delivery_method' => 'pickup',
            'delivery_type' => $this->faker->optional()->randomElement(['regular', 'super']),
            'city' => $this->faker->city,
            'area' => $this->faker->streetName,
            // 'pickup_code' => $this->faker->optional()->bothify('PC-###??'),
            'follow_up_code' => $this->faker->optional()->bothify('PC-###??'),

            'total' => $this->faker->randomFloat(2, 100, 1000),
            // 'delivery_price' => $this->faker->optional()->randomFloat(2, 10, 50),
            'finally_total' => $this->faker->randomFloat(2, 100, 1200),

            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,


            'notes' => $this->faker->optional()->sentence,
            'status_order' => $this->faker->randomElement(['pending', 'accepted', 'completed', 'cancelled']),
            'status' => $this->faker->boolean(),
            'order_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
