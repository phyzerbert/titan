<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'title', 'description', 'user_id', 'course_id', 'amount', 'request_date', 'status',
    ];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course');
    }
}
