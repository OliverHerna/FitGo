<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{   
    public function entitiabble()
    {
        return $this->morphTo();
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    public function getResourceNameAttribute()
    {
        return Module::where('name', 'like', Str::after($this->entitiabble_type, "\\"))->value('resource_name');
    }
}
