<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignerAnnex extends Model
{
    protected $fillable = [
        'name',
        'file_path',
        'project_id'
    ];

    protected $with = [
        'project'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

}
