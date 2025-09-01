<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebPushSubscription extends Model
{
    protected $fillable = ['subscribable_id','subscribable_type','endpoint','public_key','auth_token'];
}
