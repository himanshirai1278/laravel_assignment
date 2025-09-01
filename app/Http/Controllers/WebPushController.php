<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebPushSubscription;
use Illuminate\Support\Facades\Auth;

class WebPushController extends Controller
{
    public function subscribe(Request $r)
    {
        $r->validate([
            'endpoint'=>'required',
            'public_key'=>'required',
            'auth_token'=>'required',
        ]);
        $user = Auth::guard('customer')->user();
        WebPushSubscription::updateOrCreate(
            ['endpoint'=>$r->endpoint],
            [
                'subscribable_id'=>$user->id,
                'subscribable_type'=>(new \App\Models\Customer)->getMorphClass(),
                'public_key'=>$r->public_key,
                'auth_token'=>$r->auth_token,
            ]
        );
        return response()->json(['ok'=>true]);
    }
}
