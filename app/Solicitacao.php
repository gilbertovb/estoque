<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $table = 'solicitacoes';
    
    protected $fillable = [
        'producao_id','produto_id','user_id','quantidade','autorizado','obs'
    ];
    
    public function produto() {
        return $this->belongsTo('App\Produto');
    }
    
    public function producao() {
        return $this->belongsTo('App\Producao');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
