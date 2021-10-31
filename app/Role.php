<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function permissions()
    {
        return $this->hasMany('App\Permission');
    }

    public function entity()
    {
        return $this->morphOne('App\Entity', 'entitiabble');
    }
}
