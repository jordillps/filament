<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number','customer_id','priority','comment', 'created_at'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function lineOrders(){
        return $this->HasMany(LineOrder::class);
    }

    public function updateOrder(){
        $lineOrders = LineOrder::where('order_id', $this->id)->pluck('subtotal')->toArray();
        $this->subtotal = array_sum($lineOrders);
        $this->tax = round($this->subtotal * 0.21,2);
        $this->total = $this->subtotal + $this->tax;
        $this->save();
    }
    
    
}
