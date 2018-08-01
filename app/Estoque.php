<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $fillable = [
        'nome', 'obs',
    ];

    public function produtos() {
        return $this->belongsToMany('App\Produto','estoque_produto','estoque_id','produto_id')->withPivot('min','atual')->withTimestamps();
    }
}
