<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreInstallation extends Model
{
    /*
        PreInstallation 1 - 1 Project
        PreInstallation 1 - N Annexes
    */

    protected $with = ['project'];

    protected $fillable = [
        'uc_data',
        'input_pattern',
        'qdg',
        'holder_data',
        'roof_data',
        'project_id',
    ];

    protected $casts = [
        'uc_data' => 'array',
        'input_pattern' => 'array',
        'qdg' => 'array',
        'holder_data' => 'array',
        'roof_data' => 'array',
    ];


    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function attachments(){
        return $this->hasMany(Attachment::class);
    }

}
