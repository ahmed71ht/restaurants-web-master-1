<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewDishEmail extends Notification
{
    use Queueable;

    public $food;

    public function __construct($food)
    {
        $this->food = $food;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('أكلة جديدة من ' . $this->food->restaurant->name)
            ->greeting('مرحبا ' . $notifiable->name)
            ->line('قام مطعم ' . $this->food->restaurant->name . ' بإضافة أكلة جديدة!')
            ->line('اسم الأكلة: ' . $this->food->name)
            ->action('عرض الأكلة', url('/restaurants/' . $this->food->restaurant->id))
            ->line('شكراً لاستخدامك موقعنا!');
    }
}
