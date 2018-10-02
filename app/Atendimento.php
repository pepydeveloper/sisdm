<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $fillable = [
        'ateid',
        'atedescricao'
    ];

    protected $table = 'atendimento';
}
