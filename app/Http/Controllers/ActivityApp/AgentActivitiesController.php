<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityApp\AgentActivityModel;

class AgentActivitiesController extends Controller
{
	public static function call()
	{
		return new AgentActivitiesController;
	}


	public function model()
	{
		return new AgentActivityModel;
	}

	public function insertOwnActivities(Array $data)
	{
		$data = (object) $data;
		$agentActivity = new AgentActivityModel;
		$agentActivity->mode = $data->mode;
		$agentActivity->title = $data->name;
		$agentActivity->destination_code = $data->cityId;
		$agentActivity->timing = $data->timing;
		$agentActivity->image_path = $data->image;
		$agentActivity->description = $data->description;
		$agentActivity->save();
		return $agentActivity->id;
	}
}
