<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{

	use Notifiable;
	protected $connection = 'mysql';
	protected $table = 'users';
	protected $appends = ['fullname', 'profile_pic', 'status'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'admin_id','firstname','lastname','username', 
			'mobile', 'email', 'password', 'type', 'is_active'
		];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token',];

	public static function call()
	{
		return new User;
	}

	
	public function getFullnameAttribute()
	{
		return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
	}

	public function getProfilePicAttribute()
	{
		return urlImage($this->attributes['image_path']);
	}



	public function getStatusAttribute()
	{   
		$status = '';
		$isActive = $this->attributes['is_active'];
		
		if ($isActive == 1) {
			$status = 'active';
		}
		elseif ($isActive == 2) {
			$status = 'suspended';
		}
		elseif ($isActive == 3) {
			$status = 'activation pending';
		}
		else {
			$status = 'inactive';
		}

		return $status;

	}


	public function admin()
	{
		return $this->belongsTo('App\Admin', 'admin_id');
	}


	public function findByIdOrFail($id)
	{
		$auth = Auth::guard('admin')->user();
		return $this->where([
												'id' => $id, 
												'admin_id' => $auth->id
											])
										->firstOrFail();
	}


	public function findByEmailOrFail($email)
	{
		$auth = Auth::guard('admin')->user();
		return $this->where([
												'email' => $email, 
												'admin_id' => $auth->id
											])
										->firstOrFail();
	}


	public function activate()
	{
		if (isset($this->id)) {
			$this->is_active = 1;
			$this->save();
		}
		return $this;
	}


	public function suspend()
	{
		if (isset($this->id)) {
			$this->is_active = 2;
			$this->save();
		}
		return $this;
	}


}
