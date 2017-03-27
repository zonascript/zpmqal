<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
// use URL;

class PagesController extends Controller
{
	public function getIndex(){
		return view('public.pages.home');
	}

	public function getHome(){
		return redirect('/#home');
	}

	public function getAbout(){
		return redirect('/#about');
	}

	public function getContact(){
		return redirect('/#contact');
	}

	public function getServices(){
		return redirect('/#services');
	}

	public function getTest(){
		return view('b2b.protected.dashboard.pages.form_advanced1');
	}

	public function getPickMe()
	{
		return 'Your cab is on the way';
	}
}
