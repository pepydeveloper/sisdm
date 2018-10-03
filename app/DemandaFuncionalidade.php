<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemandaFuncionalidade extends Model
{
    protected $fillable = [
        'defid',
        'deftipomudanca',
        'defdescricao',
        'defalteracaoarquivos',
        'defcargadados',
        'demid',
        'funid'
    ];

    protected $table = 'demanda_funcionalidade';
}
