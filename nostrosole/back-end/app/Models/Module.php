<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /*
        Module N - 1 Project
    */

    protected $fillable = [
        'brand',
        'model',
        'power',
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
