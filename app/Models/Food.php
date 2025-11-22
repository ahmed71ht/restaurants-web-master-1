<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = ['restaurant_id', 'name', 'description', 'price', 'image'];

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

    public function comments()
    {
        return $this->hasMany(FoodComment::class);
    }

}
