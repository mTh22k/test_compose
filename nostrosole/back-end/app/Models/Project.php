<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /*
        Project 1 - N Modules    
        Project 1 - N Inverters  
        Project 1 - N Andamentos 
        Project 1 - N Annexes  
        Project 1 - N ProjectistAnnexes 
    */

    protected $fillable = [
        'holder', // consumer unit holder
        'group', 
        'status',               
        'statusDescription',   
        'projectistObservation',// designerObservation
        'isInspectionRequested'
    ];


    public function modules(){                  
        return $this->hasMany(Module::class);
    }

    public function inverters(){                
        return $this->hasMany(Inverter::class);
    }

    public function attachments(){              
        return $this->hasMany(Attachment::class);
    }

    public function designerAnnexes(){
        return $this->hasMany(DesignerAnnex::class);
    }

    public function progresses(){
        return $this->hasMany(Progress::class);
    }

    public function preInstallation(){
        return $this->hasOne(PreInstallation::class);
    }
}
