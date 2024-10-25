<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = [
        'info',
        'data',     // Formato: 'YYYY-MM-DD'
        'color',
        'project_id'
    ];

    protected $with = [
        'project'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

}
