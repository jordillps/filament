<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description', 'photo_path'];


    public function processes(){
        return $this->belongsToMany(Process::class);
    }

    public function lineOrders(){
        return $this->HasMany(LineOrder::class);
    }

    public function updateProductPrice(){
        $productProcessesPrice = [];
        $productProcesses = $this->processes;
        foreach($productProcesses as $process){
            array_push( $productProcessesPrice, $process->price );
        }
        $this->price = array_sum($productProcessesPrice);
        $this->save();
    }

}
