<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    public $timestamps = false;

    public function subtasks(){
        return $this->hasMany('App\SubTask','task_id','task_id');
    }
    public function pxu(){
        return $this->belongsTo('App\ProjectsXUsers', 'pxu_id', 'pxu_id');
    }
}
