<?php

namespace App\Models\CommonApp;

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

	public function getCountries($search){

		$result = $this->select()
						->whereRaw("`country` LIKE '%$search%'")
						->get();

		return  $result;
	}

}
