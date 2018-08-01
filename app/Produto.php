<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome', 'obs', 'unidade_id', 'tipo'
    ];
    
    public function unidade() {
        return $this->belongsTo('App\Unidade');
    }
    
    public function fichatecnica() {
        return $this->belongsToMany('App\Produto','fichastecnicas','produto1_id','produto2_id')->withPivot('quantidade')->withTimestamps();
    }
    
    public function estoques() {
        return $this->belongsToMany('App\Estoque','estoque_produto','produto_id','estoque_id')->withTimestamps();
    }
}
