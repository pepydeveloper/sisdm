<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tabelas extends Model
{
    protected $fillable = [
        'tabid',
        'tabnome',
        'tabschema'
    ];

    protected $table = 'tabelas';
}
