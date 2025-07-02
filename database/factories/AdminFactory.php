<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $password="admin123";
        return [
            "name" => fake()->name(),
            "email" => "zz@zz.com",
            'gender' => "male",
            "phone" => fake()->unique()->phoneNumber(),
            "whatsapp" => fake()->unique()->phoneNumber(),
            "address" => fake()->address(),
            "password" => bcrypt($password),
        ];
    }
}
