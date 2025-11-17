<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given order can be updated by the user.
     */
    public function update(User $user, Order $order)
    {
        return $order->delivery_id === $user->id;
    }

    public function viewDeliveryOrders(User $user, User $delivery)
    {
        return $user->id === $delivery->id;
    }

}
