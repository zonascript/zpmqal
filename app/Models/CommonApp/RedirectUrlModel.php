<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;


use Auth;
class RedirectUrlModel extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'redirect_urls';

  protected $fillable = ['status', 'user_id'];

  public static function call(){
  	return new RedirectUrlModel;
  }


  public function setStatusAttribute($value)
  {
    $this->attributes['status'] = strtolower($value);
  }


  public function findByHashId($hashId){
    // $auth = Auth::user();
  	$result = $this->select(["id", "hash_id", "token", "url"])
    	  							->where([
      											"hash_id" => $hashId, "status" => "active", 
      	  								])
      	  							->first();
  	return $result;
  }

}
