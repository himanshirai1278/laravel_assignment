<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $status;
    public $customerId;

    public function __construct(Order $order)
    {
        $this->orderId = $order->id;
        $this->status = $order->status;
        $this->customerId = $order->customer_id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('orders.' . $this->customerId);
    }

    public function broadcastAs()
    {
        return 'OrderStatusUpdated';
    }
}
