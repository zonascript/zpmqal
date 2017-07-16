<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\PackageNoteModel;

class PackageNotesController extends Controller
{

	public static function call()
	{
		return new PackageNotesController;
	}


	public function model()
	{
		return new PackageNoteModel;
	}

	public function creatOrUpdate($id = null, $text)
	{
		$note = $this->model()->find($id);
		if (is_null($note)) { $note = $this->model(); }
		$note->note = $text;
		$note->save();
		return $note->id; 
	}
}
