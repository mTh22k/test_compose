<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\PreInstallation;
use App\Models\Attachment;

class PostInstallation extends Model
{
    /*
        PostInstallation 1 - 1 Project
        PostInstallation 1 - N Annexes
        PostInstallation 1 - 1 PreInstallation 
    */
    
    protected $with = ['project', 'preInstallation', 'attachments'];

    protected $fillable = [
        'change_warning',
        'project_id',
        'pre_installation_id',
        'attachment_id',
    ];

    protected $casts = [
        'change_warning' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function preInstallation()
    {
        return $this->belongsTo(PreInstallation::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
