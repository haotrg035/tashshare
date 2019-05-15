<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    public function Tasks()
    {
        return $this->hasMany('App\Task', 'project_id', 'project_id');
    }

    public function Users()
    {
        return $this->hasManyThrough('App\User', 'App\Task','user_id','user_id','project_id');
    }
}
