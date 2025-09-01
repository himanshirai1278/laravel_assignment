<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public $orderId;
    public $status;

    public function __construct($orderId,$status)
    {
        $this->orderId = $orderId;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['broadcast','database'];
    }

    public function toArray($notifiable)
    {
        return ['order_id'=>$this->orderId,'status'=>$this->status];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
