<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'address'
    ];

    protected $hidden = [
        'password',
    ];

    // علاقة المستخدم بالمطاعم (لو كان صاحب مطعم)
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'owner_id');
    }

    // علاقة المستخدم بالطلبات (لو كان زبون)
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // علاقة المستخدم بالطلبات للتوصيل (لو كان عامل توصيل)
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'delivery_man_id');
    }
}
