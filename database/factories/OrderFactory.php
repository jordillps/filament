<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

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
    public function definition()
    {
        $subtotal = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 2000);
        $tax =  round($subtotal * 0.21,2);
        $total = $subtotal + $tax;

        return [
            'customer_id' => Customer::factory(),
            'priority' => $this->faker->randomElement(['normal', 'urgent']),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total'  => $total,
            'comment' => $this->faker->text($maxNbChars = 200)
        ];
    }
}
