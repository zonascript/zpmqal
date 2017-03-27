<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'countries';

  public function getCountry($search){

		$result = $this::select()
						->whereRaw("`country` LIKE '%$search%'")
						->first();

		return  $result;
	}
}
