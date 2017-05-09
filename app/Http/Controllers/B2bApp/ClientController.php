<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*=====================================Models=====================================*/
use App\Models\B2bApp\ClientModel;
use DB;
use Auth;


/*
| This Controller made of checking client is valid or not
| Client is attending assign user or not 
*/

class ClientController extends Controller
{

	public static function call(){
		return new ClientController;
	}

	public function model(){
		return new ClientModel;
	}


	public function all(){
		$auth = Auth::user();

		$clients = $this->model()
											->where([
														'user_id' => $auth->id,
														['status', '<>', 'deleted']
													])
												->get();;

		return $clients;
	}


	public function activeClient($id)
	{
  	return $this->model()
									->where(['id' => $id])
										->update(['status' => 'active']);

	}


	public function pendingClients()
	{
		$auth = Auth::user();

		return $this->model()
						->select('id', 'fullname', 'mobile', 'note', 'created_at')
							->where([
										'user_id' => $auth->id,
										'status' => 'pending'
									])
								->get();
	}

}
