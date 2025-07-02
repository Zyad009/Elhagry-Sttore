<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleManager>
 */
class SaleManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $password = "manager123";
        static $i = 1;

        return [
            "name" => fake()->name(),
            "email" => fake()->email(),
            'gender' => "male",

            "pickup_point_id" => $i++,
            "phone" => fake()->phoneNumber(),
            "whatsapp" => fake()->phoneNumber(),
            "address" => fake()->address(),
            "password" => bcrypt($password),
        ];
    }
}
