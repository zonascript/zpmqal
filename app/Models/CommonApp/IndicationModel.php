<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class IndicationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'indications';

	public function getNameAttribute($name)
	{
		return proper($name);
	}

	public function htmlOptions($cat, $isSelected = '', $isKey = true)
	{
		$data = $this->where(['category' => $cat])->get();
		$options = '';
		foreach ($data as $value) {
			$key = $isKey ? $value->key : $value->id;
			$selected = $isSelected == $key ? 'selected' : '';
			$options .= '<option value="'.$key.'" '.$selected.'>'
								.$value->name.'</option>';
		}
		return $options;
	}


	public function toKeyValue($cat, Array $with = [], $isKey = true)
	{
		$data = $this->where(['category' => $cat])->get();
		foreach ($data as $value) {
			$key = $isKey ? $value->key : $value->id;
			$with[$key] = $value->name;
		}
		return $with;
	}
	
}
