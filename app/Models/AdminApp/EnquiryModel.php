<?php

namespace App\Models\AdminApp;

use App\Models\B2bApp\ClientModel;
use Auth;
use DB;

class EnquiryModel extends ClientModel
{

	public static function call()
	{
		return new EnquiryModel;
	}


	public function findByAdminId($where = [])
	{
		$auth = Auth::guard('admin')->user();
		$where = array_merge(["admin_id" => $auth->id, ["status", "<>", "deleted"]], $where);

		$clients = DB::table('trawish_b2b.clients')
            ->join('trawish_b2b.users', 'trawish_b2b.clients.user_id', '=', 'trawish_b2b.users.id')
            ->join('trawish_admin.admins', 'trawish_b2b.users.id', '=', 'trawish_admin.admins.id')
            ->select([
									'trawish_b2b.clients.*', 
									'trawish_b2b.users.admin_id', 
									'trawish_b2b.users.firstname AS user_firstname', 
									'trawish_b2b.users.lastname AS user_lastname', 
									'trawish_b2b.users.username AS user_username', 
									'trawish_b2b.users.mobile As user_mobile', 
									'trawish_b2b.users.email As user_email', 
									'trawish_b2b.users.type As user_type', 
									'trawish_b2b.users.about As user_about', 
									'trawish_b2b.users.address As user_address', 
									'trawish_b2b.users.facebook As user_facebook', 
									'trawish_b2b.users.googleplus As user_googleplus', 
									'trawish_b2b.users.linkedin As user_linkedin', 
									'trawish_b2b.users.twitter As user_twitter', 
									'trawish_b2b.users.youtube As user_youtube', 
									'trawish_b2b.users.instagram As user_instagram', 
									'trawish_b2b.users.image_path As user_image_path'
								])
            ->where($where)
            ->get();

    return $clients;

	}

	public function findByUser()
	{
		$auth = Auth::guard('admin')->user();
		$auth->users = $auth->users;
		return $auth;
	}


	public function user()
	{
		return $this->belongsTo('App\Models\AdminApp\UserModel', 'user_id');
	}

	public function leadVendor()
	{
		return $this->belongsTo('App\Models\AdminApp\LeadVendorModel', 'lead_vendor_id');
	}


}
