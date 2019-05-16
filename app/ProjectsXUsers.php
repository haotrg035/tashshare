<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectsXUsers extends Model
{
    protected $table = 'projects_has_users';
    protected $primaryKey = 'pxu_id';
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany('App\Task', 'pxu_id', 'pxu_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function($pxu){
    //         $pxu->tasks()->delete();
    //     });
    // }
}
