<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminApp\UserActivationModel;
use App\Mail\VerifyMail;
use App\User;
use Mail;

class UserController extends Controller
{
	protected $viewPath = 'admin.protected.dashboard.pages.users';

	public function index()
	{
		return view($this->viewPath.'.index');
	}

	public function show($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		return view($this->viewPath.'.show', ['user' => $user]);
	}


	public function create()
	{
		return view($this->viewPath.'.create');
	}


	public function store(Request $request)
	{
		$this->validate($request, [
          'firstname' => 'required|max:255',
          'lastname' => 'required|max:255',
          'mobile' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
        ]);

		$auth = auth()->guard('admin')->user();

		User::create([
        'firstname' => $request['firstname'],
        'lastname' => $request['lastname'],
        'mobile' => $request['mobile'],
        'email' => $request['email'],
        'type' => 'agent',
        'password' => bcrypt($request['password']),
        'is_active' => 3,
        'admin_id' => $auth->id,
      ]);
		$this->sendVerifyEmail($request->email);
		return redirect('dashboard/console/manage/users');
	}


	public function edit($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		return view($this->viewPath.'.edit', ['user' => $user]);
	}


	public function update($email, Request $request)
	{
		$this->validate($request, [
				'firstname' => 'required|max:255',
				'lastname' => 'required|max:255',
				'mobile' => 'required|numeric',
				'email' => 'required|email|max:255',
			]);

		$user = User::call()->findByEmailOrFail($email);
		$user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->mobile = $request->mobile;
		$user->email = $request->email;
		$user->save();
		session()->flash('success', 'User edit.');
		return redirect('dashboard/console/manage/users');
	}


	public function getResetPassword($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		return view($this->viewPath.'.reset_password', ['user' => $user]);
	}



	public function putResetPassword($email, Request $request)
	{
		$this->validate($request, [
        'password' => 'required|min:6|confirmed',
			]);

		$user = User::call()->findByEmailOrFail($email);
    $user->password = bcrypt($request->password);
    $user->save();
		session()->flash('success', 'User('.$email.') password has been reset.');
		return redirect('dashboard/console/manage/users');
	}



	public function activateUser($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		$user->activate();
		return redirect()->back();
	}


	public function suspendUser($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		$user->suspend();
		return redirect()->back();
	}


	public function destroy($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		$user->delete();
		session()->flash('danger', 'User has been deleted.');
		return redirect()->back();
	}


	public function sendVerifyEmail($email)
	{
		$user = User::call()->findByEmailOrFail($email);
		$token = $this->createToken($user->id);
		$data = (object)[
				"name" => $user->fullname,
				"email" => $user->email,
				"link" => route('activatePendingUser', $token)	
			];
		Mail::to($data)->queue(new VerifyMail($data));
		session()->flash('success', 'Verification email sent.');
	}


	public function resendVerifyEmail($email)
	{
		$this->sendVerifyEmail($email);
		return redirect('dashboard/console/manage/users');
	}



	public function createToken($userId)
	{
		$token = mycrypt($userId);
		$new = new UserActivationModel;
		$new->user_id = $userId;
		$new->token = $token;
		$new->save();
		return $token;
	}

	public function activatePendingUser($token)
	{
		UserActivationModel::call()->activateUser($token);
		return redirect('login');
	}



}
