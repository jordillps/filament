<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->enum('priority', ['Normal', 'Urgent']);
            $table->decimal('subtotal', $precision = 8, $scale = 2)->nullable();
            $table->decimal('tax', $precision = 8, $scale = 2)->nullable();
            $table->decimal('total', $precision = 8, $scale = 2)->nullable();
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
