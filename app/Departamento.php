<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'nome',
    ];
    
    public function users() {
        return $this->hasMany('App\User');
    }
}
