<?php

namespace App\Models\AdminApp;
use App\User;

class UserModel extends User
{
	protected $connection = 'mysql';
	protected $table = 'users';

	public function clients()
	{
		return $this->hasMany('App\Models\AdminApp\EnquiryModel', 'user_id');
	}

	public function admin()
	{
		return $this->belongsTo('App\Models\AdminApp\AdminModel', 'admin_id');
	}

}
