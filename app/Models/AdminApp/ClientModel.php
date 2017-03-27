<?php

namespace App\Models\AdminApp;

use App\Models\B2bApp\ClientModel AS B2bAppClientModel;

class ClientModel extends B2bAppClientModel
{
	protected $connection = 'mysql';
	protected $table = 'clients';

}
