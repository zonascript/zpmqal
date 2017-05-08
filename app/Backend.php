<?php

namespace App;

use App\Notifications\BackendResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Backend extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql1';
    protected $appends = ['fullname', 'profile_pic'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'username', 'mobile', 'email', 'password', 'type',
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new BackendResetPassword($token));
    }

    
    public function getFullnameAttribute()
    {
        return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
    }


    public function getProfilePicAttribute()
    {
        return urlImage($this->attributes['image_path']);
    }
}
