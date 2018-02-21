<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['identifier', 'detail', 'start_date', 'end_date', 'completed'];
}
