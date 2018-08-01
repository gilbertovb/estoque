<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    protected $table = 'movimento';
    
    protected $fillable = [
        'estoque_id','produto_id','user_id','quantidade',
    ];
    
    public function estoque() {
        return $this->belongsTo('App\Estoque');
    }
    
    public function produto() {
        return $this->belongsTo('App\Produto');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
