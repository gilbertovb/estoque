<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'nome',
    ];
    
    public function produtos() {
        return $this->hasMany('App\Produto');
    }
}
