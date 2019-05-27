<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    protected $table = 'sub_task';
    protected $primaryKey = 'sub_id';
    public $timestamps = false;

    public function task(){
        $this->belongsTo('App\Task','task_id','task_id');
    }
}
