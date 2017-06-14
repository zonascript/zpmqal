<?php

namespace App\Models\AdminApp;

use App\Admin;

class AdminModel extends Admin
{
	protected $connection = 'mysql3';
	protected $table = 'admins';

}
