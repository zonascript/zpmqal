<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'countries';

  public function getCountry($search){

		$result = $this->select()
						->whereRaw("`country` LIKE '%$search%'")
						->get();

		return  $result;
	}
}