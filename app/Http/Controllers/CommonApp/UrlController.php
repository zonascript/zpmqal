<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UrlController extends Controller
{
	public $url = '';
	public $search = '{}';

	public static function call(){
		return new UrlController;
	}

	public function url($slug = '')
	{
		return str_replace('{}', $slug, $this->url);
	}

	public function __construct(Array $array=[])
	{
		$array = (object)$array;
		if (isset($array->url)) {
			$this->url = $array->url;
		}

		if (isset($array->search)) {
			$this->search = $array->search;
		}
	}

}
