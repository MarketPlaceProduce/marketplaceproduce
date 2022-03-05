<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withPivot('price')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('amount')->withTimestamps();
    }
}
