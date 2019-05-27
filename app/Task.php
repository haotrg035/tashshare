<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    public $timestamps = false;

    public function subtask(){
        return $this->hasMany('App\SubTask','task_id','task_id');
    }
}
