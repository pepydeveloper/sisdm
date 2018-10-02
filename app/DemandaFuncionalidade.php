<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemandaFuncionalidade extends Model
{
    protected $fillable = [
        'defid',
        'demid',
        'funid'
    ];

    protected $table = 'demanda_funcionalidade';
}
