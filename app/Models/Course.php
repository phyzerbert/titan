<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'project_id', 'description', 'progress', 'due_to', 'status',
    ];

    public function project(){
        return $this->belongsTo('App\Models\Project');
    }

    public function members(){
        return $this->belongsToMany('App\User', 'course_users');
    }
}
