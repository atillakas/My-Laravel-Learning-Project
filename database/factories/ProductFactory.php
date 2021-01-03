<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(6,true),
            'slug' => $this->faker->sentence(6,true),
            'description' => $this->faker->realText(3000),
            'price' => $this->faker->randomFloat(NULL, 1,  1000),
            'price_new' => $this->faker->randomFloat(NULL, 1,  1000),
            'image' => $this->faker->imageUrl(640, 480),
            'image_alt_text' => $this->faker->sentence(6,true),
            'tax_type' => $this->faker->randomElement($array = array(1, 2)),
            'tax' => $this->faker->randomElement(array(8, 18)),
            'category_id' => null,
        ];
    }
}
