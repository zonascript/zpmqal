<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityApp\ActivityModel;
use App\Http\Controllers\CommonApp\DestinationController;
use App\Http\Controllers\ActivityApp\AgentActivitiesController;
use App\Http\Controllers\ActivityApp\ViatorActivitiesController;
use App\Traits\CallTrait;

class ActivityController extends Controller
{
	use CallTrait;
	
	public $cityId = '';
	public $activities = [];
	public $activityNames = [];
	public $count = 0;

	public function model()
	{
		return new ActivityModel;
	}


	public function activities($cityId)
	{
		$this->cityId = $cityId;
		$this->agentActivities(); // pulling agent's activities
		
		if ($this->count < 20) {
			$this->fgfActivities(); // pulling fgf's activities
		}

		if ($this->count < 20) {
			$this->viatorActivities();  // pulling viator's activities
		}

		return $this->activities;
	}


	public function searchActivities($cityId, $name)
	{
		$this->cityId = $cityId;
		$agentActivities = AgentActivitiesController::call()
											->model()->findByDestination($cityId, $name);
		$this->activityObject($agentActivities); // pushing to main object

		$fgfActivities = $this->model()->findByDestination($cityId, $name);
		$this->activityObject($fgfActivities);
		
		$destination = $this->destination(); // pushing to main object
		if (isset($destination->viatorDestination->destinationId)) {
			$vCityId = $destination->viatorDestination->destinationId;
			$viatorActivities = ViatorActivitiesController::call()
													->model()->findByDestination($vCityId, $name);
			$this->activityObject($viatorActivities); // pushing to main object
		}

		return $this->activities;
	}


	public function activityNames($cityId, $name)
	{
		$this->cityId = $cityId;
		$this->searchActivities($cityId, $name);
		return array_unique(array_values($this->activityNames));
	}



	public function fgfActivities()
	{
		$activitiesData = $this->model()->findByDestination($this->cityId);
		$this->activityObject($activitiesData);
		return $this;
	}


	public function agentActivities()
	{
		$activitiesData = AgentActivitiesController::call()
											->model()->findByDestination($this->cityId);

		$this->activityObject($activitiesData);
		return $this;
	}


	public function viatorActivities()
	{
		$destination = $this->destination();
		if (!is_null($destination->viatorDestination)) {
			$cityId = $destination->viatorDestination->destinationId;
			$activitiesData = ViatorActivitiesController::call()
												->model()->findByDestination($cityId);
			$this->activityObject($activitiesData);
		}
		return $this;
	}


	public function activityObject($activitiesData)
	{
		$this->count += $activitiesData->count();
		foreach ($activitiesData as $activity) {
			$ukey = $activity->vendor.'_'.$activity->id;
			if (!isset($this->activities[$ukey])) {

				$name = $activity->title;
				$image = $activity->image_url;
				$description = $activity->description;

				if ($activity->vendor == 'f') {
					$name = $activity->name;
				}
				elseif ($activity->vendor == 'v') {
					$image = $activity->thumbnailURL;
					$description = $activity->shortDescription;
				}

				$this->activities[$ukey] = (object)[
						'ukey' => $ukey,
						'code' => $activity->id,
						'vendor' => $activity->vendor,
						'image' => $image,
						'name' => $name,
						'description' => $description,
						'date' => '',
						'timing' => '',
						'mode' => '',
						'isSelected' => 0
					];

				$this->activityNames[$ukey] = $name;
			}
		}
	}


	public function destination()
	{
		return DestinationController::call()->model()->find($this->cityId);
	}



}
