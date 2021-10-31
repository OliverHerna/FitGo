<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class PaqueteUser extends Model
{
    public function entity()
    {
        return $this->morphOne('App\Entity', 'entitiabble');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function paquete()
    {
        return $this->belongsTo('App\Paquete', 'paquete_id');
    }
    public function benefit()
    {
        return $this->belongsTo('App\Benefit', 'benefit_id');
    }
    public function order()
    {
        return $this->hasMany('App\Order');
    }
    public function getHoursSpentPercentAttribute()
    {
        $order = $this->order;
        $hours = $order->sum('hours');
        $percent = ($hours * 100) / $this->paquete->total_hours;
        return number_format($percent, 2);
    }
    public function getHoursSpentValueAttribute()
    {
        $order = $this->order;
        $hours = $order->sum('hours');
        return number_format($hours, 2);
    }
    public function getHoursLeftPercentAttribute()
    {
        $order = $this->order;
        $hours =  $this->paquete->total_hours - $order->sum('hours');
        $percent = ($hours * 100) / $this->paquete->total_hours;
        return number_format($percent, 2);
    }
    public function getHoursLeftValueAttribute()
    {
        $order = $this->order;
        $hours =  $this->paquete->total_hours - $order->sum('hours');
        return number_format($hours, 2);
    }
}