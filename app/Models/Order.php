<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['customer_id','status','total'];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

class OrderItem extends Model
{
    protected $fillable = ['order_id','product_id','quantity','price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
