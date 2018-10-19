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
        'demdatainicio' => '',
        'demdatafinalizacao' => '',
        'sisid'
    ];

    protected $table = 'demanda';

    public function sistema(){
        return $this->hasOne('App\Sistema','sisid','sisid');
    }
}
