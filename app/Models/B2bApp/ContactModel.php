<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ContactModel extends Model
{
	protected $table = 'contacts'; 

	public static function call(){
		return new ContactModel;
	}

	public function setUserIdAttribute($value = null)
	{
		if (is_null($value)) {
			$auth = Auth::user();
			$value = $auth->id;
		}

		$this->attributes['user_id'] = $value;
	}


  public function self_search($word){
  	$auth = Auth::user();
  	$result = $this->select()
  									->whereRaw("CONCAT(`title`, '', `fullname`, ' ', `phone`, ' ', `email`) LIKE '%$word%' AND `status` = 'Active' AND `user_id` = '".$auth->id."'")
	  									->get();

		return $result;
	}
}
