<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $timestamps = false;

     public function pxu()
     {
         return $this->hasMany('App\ProjectsXUsers', 'project_id', 'project_id');
     }

     public function tasks(){
         return $this->hasManyThrough('App\Task','App\ProjectsXUsers','project_id','pxu_id','project_id');
     }


}
