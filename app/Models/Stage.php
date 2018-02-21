<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'default'];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
