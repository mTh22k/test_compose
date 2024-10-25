<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    /*
        Inverter N - 1 Project
    */

    protected $fillable = [
        'brand',
        'model',
        'power', // potency - potencia
        'quantity',
        'totalPower',
        'project_id'
    ];

    protected $with = [
        'project'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
