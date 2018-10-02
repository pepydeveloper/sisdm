<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncionalideTabelas extends Model
{
    protected $fillable = [
        'tafid',
        'funid',
        'tabid',
        'tafpermissao'
    ];

    protected $table = 'funcionalidade_tabelas';
}
