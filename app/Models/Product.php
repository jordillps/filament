<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description', 'image'];


    public function processes(){
        return $this->belongsToMany(Process::class);
    }

    public function lineOrders(){
        return $this->HasMany(LineOrder::class);
    }

}
