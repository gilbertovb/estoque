<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    protected $table = 'fichastecnicas';
    
    protected $fillable = [
        'produto1_id','produto2_id','quantidade',
    ];
    
    public function produtos() {
        return $this->belongsTo('App\Produto','produto1_id','produto2_id');
    }
}
