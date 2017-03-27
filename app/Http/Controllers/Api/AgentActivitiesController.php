<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\AgentActivityModel;

class AgentActivitiesController extends Controller
{
	public static function call()
	{
		return new AgentActivitiesController;
	}

	public function insert($actvities)
	{
		foreach ($variable as $key => $value) {
			# code...
		}
		$ids = AgentActivityModel::insertGetId($actvities);
	}

	public function insertOwnActivities($actvities, $destCode)
	{
		$selectedIndex = [];

		foreach ($actvities as &$actvity) {
			$agentActivity = new AgentActivityModel;
			$agentActivity->status = 'active';
			$agentActivity->mode = $actvity['mode'];
			$agentActivity->title = $actvity['name'];
			$agentActivity->destination_code = $destCode;
			$agentActivity->timing = $actvity['timing'];
			$agentActivity->image_path = $actvity['image_path'];
			$agentActivity->description = $actvity['description'];
			$agentActivity->admin_id = null; //no need to add here it is adding in model
			$agentActivity->save();

			$actvity['rank'] = 0;
			$actvity['currency'] = 'INR';
			$actvity['status'] = 'active';
			$actvity['id'] = $agentActivity->id;
			$actvity['code'] = 'OWN'.$agentActivity->id;
			$actvity['destinationCode'] = $destCode;
			$actvity['image'] = urlImage($actvity['image_path']);

			$selectedIndex['OWN'.$agentActivity->id] = [
					'mode' => $actvity['mode'],
					'date' => $actvity['date'],
					'timing' => $actvity['timing'],
					'vendor' => 'own',
					'activityCode' => $agentActivity->id,
				];
		}

		return ['actvities' => $actvities, 'selectedIndex' => $selectedIndex];

	}
}
