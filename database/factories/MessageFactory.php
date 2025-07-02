<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subject ="Lorem ipsum dolor sit";

        return [
            "name" => fake()->name(),
            "email" => fake()->email(),
            "phone" => fake()->phoneNumber(),
            "subject" => $subject ,
            "message" => "Lorem ipsum dolor sit ame123 message message Lorem ipsum dolor sit ame123 message message",
        ];
    }
}
