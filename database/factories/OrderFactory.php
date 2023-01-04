<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Order;


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
        // $subtotal = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 2000);
        // $tax =  round($subtotal * 0.21,2);
        // $total = $subtotal + $tax;

        // $lastOrder = Order::latest()->first();
        // if ($lastOrder == null) {
        //     $nextInvoiceNumber = date("Y"). '-' . '0001';
        // }else{
        //     $string = preg_replace("/[^0-9\.]/", '', $lastOrder->order_number);
        //     dd($string);
        //     $nextInvoiceNumber = date("Y") . sprintf('%04d', $string+1);
        // }
       
        return [
            'customer_id' => Customer::factory(),
            'priority' => $this->faker->randomElement(['Normal', 'Urgent']),
            // 'subtotal' => $subtotal,
            // 'tax' => $tax,
            // 'total'  => $total,
            'comment' => $this->faker->text($maxNbChars = 200)
        ];
    }
}
