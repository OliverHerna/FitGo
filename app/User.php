<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function entity()
    {
        return $this->morphOne('App\Entity', 'entitiabble');
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }
    public function paquetes()
    {
        return $this->belongsToMany('App\Paquete', 'paquete_users')->withTimestamps();
    }

    public function paquete_user()
    {
        return $this->hasMany('App\PaqueteUser');
    }
    public function getActivePackageAttribute()
    {

        $paquetes = $this->paquete_user;
        $valids = $paquetes->reject(function ($query) {
            $s = $query->order->sum('hours');
            if ($s == $query->paquete->total_hours) {
                return $query;
            }
        });
        // $hours =  $this->paquete->total_hours - $order->sum('hours');
        return $valids;
    }

    public function getFinishedPackagesAttribute()
    {
        $paquetes = $this->paquete_user;
        $valids = $paquetes->reject(function ($query) {
            $s = $query->order->sum('hours');
            if ($s < $query->paquete->total_hours) {
                return $query;
            }
        });
        // $hours =  $this->paquete->total_hours - $order->sum('hours');
        return $valids;
    }

    public function getTotalPackagesHoursAttribute($user)
    {
        $hours = 0;
        $paquetes = $user->ActivePackage;
        foreach ($paquetes as $paquetes_user) {
            $hours = $hours + $paquetes_user->paquete->total_hours;
        }
        return $hours;
    }
}
