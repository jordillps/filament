<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Process;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Models\LineOrder;
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

        //Create migration with Users

        //  Role::factory(1)->create(['name' => 'super_admin']);
        //  Role::factory(1)->create(['name' => 'filament_user']);

        //  User::factory()->create([
        //     'name' => 'Jordi Llobet',
        //     'email' => 'admin@admin.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'photo_path' => 'user-20-12-2022-16-21-37-JordiLlobet.jpg'
        // ]);

        // User::factory()->create([
        //     'name' => 'User User',
        //     'email' => 'user@user.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // ]);


        //Create migration without Users
        //Customers
        Customer::factory(10)->create();

        //Products
        Product::factory(10)->create();

        //Process
        $process = Process::factory(20)->create();

        //Orders
        // DB::table('orders')->insert([
        //     'order_number' => date("Y"). '-' . '0001',
        //     'customer_id' => 1,
        //     'priority' => 'Normal',
        //     'comment' => 'Pedido inicial de la empresa'
        // ]);
        
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0001' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0002' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0003' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0004' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0005' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0006' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0007' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0008' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0009' ]);
        Order::factory(1)->create(['order_number' => date("Y"). '-' . '0010' ]);

        //Insert in process_product table
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                DB::table('process_product')->insert([
                    'process_id' => $j*2,
                    'product_id' => $i,
                ]);
            }
        }

        //Insert Price in Product
        for ($i = 1; $i <= 10; $i++) {
            $productProcessesPrice = [];
            $product = Product::where('id', $i)->first();
            $productProcesses = $product->processes;
            foreach($productProcesses as $process){
                array_push( $productProcessesPrice, $process->price );
            }
            $product->price = array_sum($productProcessesPrice);
            $product->save();
        }
    }
}
