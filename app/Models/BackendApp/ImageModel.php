<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'images';	
}
