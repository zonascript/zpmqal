<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;
    protected $table = 'users';

    protected $appends = ['fullname', 'profile_pic'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','username', 'mobile', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function getFullnameAttribute()
    {
        return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
    }

    public function getProfilePicAttribute()
    {
        return urlImage($this->attributes['image_path']);
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }


}
