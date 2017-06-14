<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\AdminApp\LeadVendorModel;
use App\Models\AdminApp\PackageModel;
use App\Models\AdminApp\UserModel;
use App\Models\AdminApp\TextModel;

class Admin extends Authenticatable
{
	use Notifiable;
	
	protected $connection = 'mysql3';
	protected $appends = ['fullname', 'profile_pic'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname','lastname', 'companyname', 'username', 'mobile', 'email', 'password', 'type',
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
		$this->notify(new AdminResetPassword($token));
	}

	
  public function getFullnameAttribute()
  {
    return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
  }

  public function getProfilePicAttribute()
  {
    return urlImage($this->attributes['image_path']);
  }


  public function getBalanceAttribute($value)
  {
  	return round($value, 2);
  }


	public function users()
	{
		return $this->hasMany(UserModel::class, 'admin_id');
	}

	public function texts()
	{
		$result = $this->hasMany(TextModel::class, 'admin_id');
		
		return $result->where(["status" => 'active'])->orderBy("order","asc");
	}

	public function leadVendors()
	{
		$result = $this->hasMany(LeadVendorModel::class, 'admin_id');
		
		return $result->where(["status" => 'active']);
	}


	public function package()
	{
		return $this->belongsTo(PackageModel::class, 'package_id');
	}


	public function isPackageActive()
	{
		$result = false;
		if (!is_null($this->package) ) {
			$result = $this->package->is_active;
		}

		return $result;

	}

}
