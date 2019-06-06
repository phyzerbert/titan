<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'user_id', 'description', 'due_to', 'progress', 'company_id', 'limit',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

    public function courses(){
        return $this->hasMany('App\Models\Course');
    }

    public function requests(){
        return $this->hasMany('App\Models\Request');
    }
}
