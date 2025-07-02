<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerService>
 */
class CustomerServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $password = "customer123";
        return [
            "name"=> fake()->name(),
            "email"=> fake()->email(),
            'gender' => "male",

            "phone"=> fake()->phoneNumber(),
            "whatsapp"=> fake()->phoneNumber(),
            "address"=> fake()->address(),
            "password"=> bcrypt($password),
        ];
    }
}
