<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $fillable = [
        'sisid',
        'sisnome',
        'siscodigo',
        'sisdescricao'
    ];

    protected $table = 'sistema';

    public function demandas(){
        return $this->hasMany(Demanda::class, 'sisid');
    }
}
