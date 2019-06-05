<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo('App\Models\Role');
    }

    public function projects(){
        return $this->hasMany('App\Models\Project');
    }

    public function courses(){
        return $this->belongsToMany('App\Models\Course', 'course_users');
    }

    public function hasCourse($course_id){
        $courses = $this->courses;
        foreach ($courses as $value) {
            if($value->id == $course_id){
                return true;
            }
        }
        return false;
    }

    public function requests(){
        return $this->hasMany('App\Models\Request');
    }
}
