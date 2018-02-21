<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $fillable = ['name', 'default'];

    public function tasks(){
        return $this->belongsTo(Task::class, 'type_id');
    }
}
