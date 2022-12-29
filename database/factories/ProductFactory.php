<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        $name = $this->faker->sentence($nbWords = 6, $variableNbWords = true);
        $slug = Str::slug($name);
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true), 
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 600),
        ];
    }
}
