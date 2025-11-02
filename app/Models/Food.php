<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'name', 'description', 'price'
    ];
    protected $table = 'foods';

    // المطعم الذي ينتمي إليه الطعام
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // الطلبات التي تحتوي هذا الطعام (many-to-many)
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_food')->withPivot('quantity')->withTimestamps();
    }
}
