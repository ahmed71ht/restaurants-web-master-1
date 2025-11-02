<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'restaurant_id', 'status', 'total_price', 'location'
    ];

    // الزبون
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // المطعم
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // الأصناف الموجودة بالطلب
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'order_food')->withPivot('quantity')->withTimestamps();
    }

    // التوصيل المرتبط بالطلب
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}
