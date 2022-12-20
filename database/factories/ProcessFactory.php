<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Process>
 */
class ProcessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'weight' =>$this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10), 
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            'unit' => $this->faker->word, 
            'type' => $this->faker->randomElement(['product', 'service','material']),
            'status' =>$this->faker->randomElement(['pending', 'finished']),
        ];
    }
}
