<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionalidade extends Model
{
    protected $fillable = [
        'funid',
        'funnome',
        'fundescricao',
        'sisid'
    ];

    protected $table = 'funcionalidade';
}
