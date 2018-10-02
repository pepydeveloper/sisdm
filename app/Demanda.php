<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demanda extends Model
{
    protected $fillable = [
        'demid',
        'demnumero',
        'demdescricao',
        'demtipo',
        'demdatafinalizacao',
        'sisid'
    ];

    protected $table = 'demanda';

    public function sistema(){
        return $this->belongsTo(Sistema::class, 'sisid');
    }
}
