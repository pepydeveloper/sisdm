<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemandaAtendimento extends Model
{
    protected $fillable = [
        'datid',
        'datdescricao',
        'datquantidade',
        'demid',
        'ateid'
    ];

    protected $table = 'demanda_atendimento';
}
