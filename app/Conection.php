<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conection extends Model
{
    protected $fillable = [
        'name',
        'product',
        'nominal_current',
        'poles','break_current',
        'outdoor_protection',
        'project_id',
        'title'
    ];
    
    public function project(){
        
        return $this->belongsTo('App\Project');
    }
}
