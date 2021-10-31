<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public function paquete_users()
    {
        return $this->BelongsTo('App\PaqueteUser', 'paquete_user_id');
    }
    public function entity()
    {
        return $this->belongsTo('App\Entity');
    }
    public function getUserNameAttribute()
    {

        $us = Entity::where(
            [
                ['entitiabble_type', 'App\Order'],
                ['entitiabble_id', $this->id]
            ]
        )->first();
        return ($us->load('logs.user')->logs->first()->user);
    }
}