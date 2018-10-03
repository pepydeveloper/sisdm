<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncionalideTabelas extends Model
{
    protected $fillable = [
        'tafid',
        'tafutilizada',
        'taftipoacesso',
        'funid',
        'tabid',
    ];

    protected $table = 'funcionalidade_tabelas';
}
