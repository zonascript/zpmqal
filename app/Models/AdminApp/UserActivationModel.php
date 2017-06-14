<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserActivationModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'user_activations';

	public static function call()
	{
		return new UserActivationModel;
	}


	public function findByTokenOrExit($token)
	{
		return $this->where(['token' => $token])->firstOrFail();
	}


	public function updateUsed($userId)
	{
		$this->call()
						->where(['user_id' => $userId, 'is_used' =>  0])
							->update(['is_used' => 1]);
	}


	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}


	public function activateUser($token)
	{
		$rsp = true;
		$user = $this->where(['token' => $token])
									->first();
		if (is_null($user)) {
			exit('Sorry the link has been expired. <a href="'.url('/login').'">back</a>');
		}
		elseif (!$user->is_used) {
			if ($user->user->is_active != 1) {
				$user->user->is_active = 1;
				$user->user->save();
				$rsp = false;
			}
			$this->updateUsed($user->user_id);
		}

		return $rsp;
	}
}
