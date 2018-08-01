<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producao extends Model
{
    protected $table = 'producao';
    
    protected $fillable = [
        'produto_id','user_id','quantidade','produzido','obs'
    ];
    
    public function produto() {
        return $this->belongsTo('App\Produto');
    }
        
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function solicitacoes() {
        return $this->hasMany('App\Solicitacao');
    }
}
