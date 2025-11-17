<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['delivery_id', 'owner_id','name','description','image','location'];

    // صاحب المطعم
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // الأصناف
    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    // الطلبات المرتبطة بالمطعم
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
