<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    // public function PXU()
    // {
    //     return $this->hasMany('App\ProjectsXUsers', 'project_id', 'project_id');
    // }
}
