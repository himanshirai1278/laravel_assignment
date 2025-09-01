<?php

namespace App\Events;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPresenceUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $guard;
    public $userId;
    public $isOnline;

    public function __construct(string $guard, int $userId, bool $isOnline)
    {
        $this->guard = $guard;
        $this->userId = $userId;
        $this->isOnline = $isOnline;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('presence.admin-dashboard');
    }

    public function broadcastAs()
    {
        return 'UserPresenceUpdated';
    }
}
