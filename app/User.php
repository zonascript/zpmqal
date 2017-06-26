<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\CommonApp\IndicationModel;
use App\Admin;

class User extends Authenticatable
{

	use Notifiable;
	protected $connection = 'mysql';
	protected $table = 'users';
	protected $appends = ['fullname', 'profile_pic'];
	
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



	public function status()
	{   
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function admin()
	{
		return $this->belongsTo(Admin::class, 'admin_id');
	}


	public function findByIdOrFail($id)
	{
		$auth = auth()->guard('admin')->user();
		return $this->where([
												'id' => $id, 
												'admin_id' => $auth->id
											])
										->firstOrFail();
	}


	public function findByEmailOrFail($email)
	{
		$auth = auth()->guard('admin')->user();
		return $this->where([
												'email' => $email, 
												'admin_id' => $auth->id
											])
										->firstOrFail();
	}


	public function activate()
	{
		if (isset($this->id) && $this->is_active != 3) {
			$this->is_active = 1;
			$this->save();
			session()->flash('success', 'User activated');
		}
		else{
			session()->flash('warning', 'Verification pending.');
		}
		return $this;
	}


	public function suspend()
	{
		if (isset($this->id) && $this->is_active != 3) {
			$this->is_active = 2;
			$this->save();
			session()->flash('danger', 'User suspended');
		}
		else{
			session()->flash('warning', 'Verification pending.');
		}
		return $this;
	}


}
