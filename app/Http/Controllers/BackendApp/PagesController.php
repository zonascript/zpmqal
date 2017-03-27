<?php

namespace App\Http\Controllers\backendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PagesController extends Controller
{
	public function getIndex(){
    return view('backend.home');
	}

  public function getHome(){
    return view('backend.home');
  }


}
