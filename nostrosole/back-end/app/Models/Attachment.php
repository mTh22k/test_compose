<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /*
        Attachment N - 1 Project
        Attachment N - 1 PreInstallation
    */

    protected $fillable = [
        'name',
        'file',
        'project_id',
        'pre_installation_id'
    ];

    protected $with = [
        'project',
        'preInstallation'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function preInstallation(){
        return $this->belongsTo(PreInstallation::class);
    }
}
