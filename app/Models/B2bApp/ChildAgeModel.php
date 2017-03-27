<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class ChildAgeModel extends Model
{
	protected $table = 'children_age';

	protected $hidden = [
		'created_at', 'updated_at',
	];

	


}
