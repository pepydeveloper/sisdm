<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tabelas extends Model
{
    protected $fillable = [
        'tabid',
        'tabowner',
        'tabnome'
    ];

    protected $table = 'tabelas';
}
