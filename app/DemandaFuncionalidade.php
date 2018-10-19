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
        'evidencia1',
        'evidencia2',
        'evidencia3',
        'demid',
        'funid'
    ];

    protected $table = 'demanda_funcionalidade';
}
