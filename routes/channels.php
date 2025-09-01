<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('orders.{customerId}', function ($user, $customerId) {
    $guard = request()->header('X-Socket-Guard','customer');
    if ($guard==='customer' && auth('customer')->check() && auth('customer')->id() == (int)$customerId) {
        return ['id'=>$customerId];
    }
    return false;
});

Broadcast::channel('presence.admin-dashboard', function ($user) {
    $guard = auth('admin')->check() ? 'admin' : (auth('customer')->check() ? 'customer' : 'guest');
    return ['id'=>$user->id ?? 0, 'guard'=>$guard, 'name'=>$user->name ?? 'Guest'];
});
