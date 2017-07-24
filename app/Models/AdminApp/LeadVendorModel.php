<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;
use App\Models\CommonApp\ImageModel;

class LeadVendorModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'lead_vendors';
	protected $appends = ['status', 'image'];


	public function getImageAttribute()
	{
		return is_null($this->imageData) 
					 ? urlDefaultImageProfile()
					 : $this->imageData->url;
	}

	public function getStatusAttribute()
	{
		return is_null($this->indication) ? '' : $this->indication->name;
	}


	public function indication()
	{
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function imageData()
	{
		return $this->belongsTo(ImageModel::class, 'image_id');
	}


	public function scopeAdminId($query)
	{
		$auth = auth()->guard('admin')->user();
		return $query->where('admin_id', $auth->id);
	}


	public function scopeSearch($query, $keyword = '')
	{
		return $query->where(function ($q) use ($keyword){
								$q->orWhere('email_id', 'like', '%'.$keyword.'%');
								$q->orWhere('company_name', 'like', '%'.$keyword.'%');
								$q->orWhere('contact_person', 'like', '%'.$keyword.'%');
								$q->orWhere('contact_number', 'like', '%'.$keyword.'%');
							});
		
	}

	public function paginatedData($keyword = '')
	{
		return $this->adminId()
									->search($keyword)
										->simplePaginate(6);
	}


}
