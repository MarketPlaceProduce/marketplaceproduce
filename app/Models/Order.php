<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'deliver_at' => 'datetime',
    ];

    public function total(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->products->sum(function ($product) {
                    return ($product->customers->find($this->id)->pivot->price ?? $product->default_price) * $product->pivot->amount;
                });
            }
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('amount')->withTimestamps();
    }
}
