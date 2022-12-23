<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Process;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
            'name' => 'Jordi Llobet',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'photo_path' => 'user-20-12-2022-16-21-37-JordiLlobet.jpg'
        ]);

        //Customers
        Customer::factory(10)->create();

        //Products
        Product::factory(10)->create();

        //Process
        $process = Process::factory(20)->create();

        //Orders
        Order::factory(10)->create();

        //Insert in order_product table
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                DB::table('order_product')->insert([
                    'order_id' => $i,
                    'product_id' => $j*2,
                ]);
            }
        }

        //Insert in process_product table
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                DB::table('process_product')->insert([
                    'process_id' => $j*2,
                    'product_id' => $i,
                ]);
            }
        }
    }
}
