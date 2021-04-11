<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'sku' => $this->faker->uuid,
            'qty' => $this->faker->randomNumber(2),
            'description' => $this->faker->paragraph(),
            'short_description' => $this->faker->text(255),
        ];
    }
}
