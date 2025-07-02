<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pricies = ['100', '200', '300' ,'400' ,'500'];
        $price = $pricies[rand(0, 4)];

        return [
            "name" => fake()->name(),
            "price" => $price,
            "QTY" =>'0',
            "description" =>"Lorem ipsum dolor sit ame123",
            "category_id" => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $mainImage = config("default-image.main-image");
            $hoverImage = config("default-image.hover-image");
            $image = config("default-image.image");
            Image::create([
                "folder" => "public/admin/products",
                "main_image" => $mainImage ,
                "hover_image" => $hoverImage,
                "images" => json_encode([$image]) ,
                "imageable_id" => $product->id,
                "imageable_type" => Product::class,
            ]);
        });
    }
}
