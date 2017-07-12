<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\ClientModel;
use App\Models\B2bApp\ClientAliasModel;


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

	public function aliasModel()
	{
		return new ClientAliasModel;
	}


	public function all(){
		$auth = auth()->user();
		$clients = $this->model()
											->where([
														'user_id' => $auth->id,
														['is_active', '<>', 0]
													])
												->get();
		return $clients;
	}


	public function activeClient($id)
	{
  	return $this->model()
									->where(['id' => $id])
										->update(['is_active' => 1]);

	}


	public function pendingClients()
	{
		$auth = auth()->user();

		return $this->model()
						->select('id', 'fullname', 'mobile', 'note', 'created_at')
							->where([
										'user_id' => $auth->id,
										'is_active' => 3
									])
								->get();
	}


}
