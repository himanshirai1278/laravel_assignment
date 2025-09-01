<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Minishlink\WebPush\Subscription;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','email','password'];

    protected $hidden = ['password','remember_token'];

    public function routeNotificationForWebPush($notification)
    {
        return $this->webPushSubscriptions()->get()->map(function($sub){
            return [
                'endpoint' => $sub->endpoint,
                'keys' => [
                    'p256dh' => $sub->public_key,
                    'auth' => $sub->auth_token,
                ],
            ];
        })->toArray();
    }

    public function webPushSubscriptions()
    {
        return $this->morphMany(\App\Models\WebPushSubscription::class, 'subscribable');
    }
}
