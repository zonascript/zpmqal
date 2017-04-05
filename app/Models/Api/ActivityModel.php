<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

// =============================Models=============================
use App\Models\Api\DestinationModel;
use Auth;
use DB;

class ActivityModel extends Model
{
	protected $table = 'activities';
	protected $appends = ['vendor'];
	protected $connection = 'mysql2';

	public static function call(){
		return new ActivityModel;
	}


	public function getVendorAttribute()
	{
		return 'f';
	}


	public function getActivities($cityId, $date){

		$Location = DestinationModel::call()->findByDcode($cityId);
		$Location = rejson_decode($Location, true);

		$sqlQuery = (
			"SELECT CONCAT(A.`Prefix`, A.`ID`) AS ActivityCode, A.`name` AS ActivityName, A.`CountryCode`, 
				A.`DestinationCode`, D.`Destination`, A.`Currency`, A.`Description`, 
				A.`FromDate` AS ValidFrom, A.`ToDate` AS ValidTo, A.`PrivateStatus`,
				A.`PriCabIncl`, A.`AdultPrice`, A.`SicStatus`, A.`AdultTktSic`, A.`CabStatus`,
				A_CC.`ChildCharges`, A_C.`Cars`, A_T.`Timing`, A_I.`Images`
			
			FROM activities AS A 
			
			LEFT JOIN (
				SELECT 
					CC.activityId AS CC_activityId, 
					CONCAT('[',GROUP_CONCAT( CONCAT(
						'{\"ID\":\"', CONCAT(CC.`Prefix`, CC.`ID`),'\",\"FromAge\":\"', CC.FromAge,'\",\"ToAge\":\"', CC.ToAge,'\",\"Type\":\"', CC.Type,'\",\"Price\":\"', CC.Price, '\"}
					') ),']') AS ChildCharges

				FROM `activities_childcharges` CC 
				GROUP BY CC_activityId
			) A_CC ON A_CC.CC_activityId = CONCAT(A.Prefix,A.ID)
			
			LEFT JOIN (
				SELECT 
					C.activityId AS C_activityId, 
					CONCAT('[',GROUP_CONCAT( CONCAT(
						'{\"ID\":\"', CONCAT(C.`Prefix`, C.`ID`),'\",\"SeatingCapacity\":\"', C.Capacity,'\",\"CarName\":\"', C.CarName,'\",\"Price\":\"', C.Price, '\"}
					') ),']') AS Cars

				FROM `activities_cars` C 
				GROUP BY C_activityId
			) A_C ON A_C.C_activityId = CONCAT(A.Prefix,A.ID)
			
			LEFT JOIN (
				SELECT 
					T.activityId AS T_activityId, 
					CONCAT('[',GROUP_CONCAT( CONCAT(
						'{\"OpeningTime\":\"', T.OpeningTime,'\",\"ClosingTime\":\"', T.ClosingTime,'\",\"Duration\":\"', T.Duration,'\",\"Remarks\":\"', T.Remarks, '\"}
					') ),']') AS Timing

				FROM `activities_timings` T 
				GROUP BY T_activityId
			) A_T ON A_T.T_activityId = CONCAT(A.Prefix,A.ID)

			LEFT JOIN (
				SELECT 
					I.relationId AS I_relationId, 
					CONCAT('[',GROUP_CONCAT( CONCAT(
					'{\"id\":\"', I.id,'\",\"type\":\"', I.type,'\",\"path_or_url\":\"', I.path_or_url, '\"}
					') ),']') AS images

				FROM `images` I
				GROUP BY I_relationId
			) A_I ON A_I.I_relationId = CONCAT(A.Prefix,A.ID)

			LEFT JOIN destinations AS D ON D.fgf_destinationcode = A.DestinationCode
			WHERE A.`DestinationCode` = '$cityId'
				AND A.`FromDate` <= '$date' AND A.`ToDate` >= '$date' 
			GROUP BY CONCAT(A.`Prefix`, A.`ID`)"
		);


		DB::connection('mysql2')->statement('SET SESSION group_concat_max_len = 1000000');
		$result = DB::connection('mysql2')->select(DB::raw($sqlQuery));
		$result = json_decodeMulti($result, true);
		// dd_pre_echo($result);

		if (is_array($result) && count($result) > 0) {
			foreach ($result as $key => &$value) {
				$value['ToursType'] = [];

				if (isset($value['Timing'])) {
					// $value['Timing'] = json_decode($value['Timing'], true);
				}

				// ===========================Calculating Sic Here===========================
				if (isset($value['SicStatus']) && isset($value['AdultTktSic']) && $value['SicStatus'] == 1) {
					$value['Sic']['Price']['Adult'] = $value['AdultTktSic'];
					unset($value['AdultTktSic']);
				}
				else{
					$value['Sic'] = [];
					unset($value['AdultTktSic']);
				}


				// =====================Calculating Private And Car here=====================
				if (isset($value['PrivateStatus']) && $value['PrivateStatus'] == 1) {
					
					$value['Private']['Price']['Adult'] = $value['AdultPrice'];
					unset($value['AdultPrice']);

					// =========================Fixing Cars array here=========================
					// $cars_array = json_decode($value['Cars'], true);
					$cars_array = $value['Cars'];
					if (bool_array($cars_array)) {
						usort($cars_array,'sortBySeatingCapacity');
						$value['Private']['Cars'] = $cars_array;
					}




					/* //=============this is for saparate cars on seater capcity=============
					
					if (bool_array($value['Cars']) && isset($value['PriCabIncl']) && $value['PriCabIncl'] == 1 ) {
						$carArrayTemp = [];
						
						foreach ($value['Cars'] as $car_key => $car_value) {
							$carArrayTemp[$car_value['Capacity']][] = $car_value;
						}
					
						$value['Private']['Cars'] = $carArrayTemp;
					}; */

				}
				else{
					$value['Private'] = [];
				}
				unset($value['Cars']);


				// ==============================Fixing Child here==============================
				if (isset($value['ChildCharges']) && !empty($value['ChildCharges'])) {
					// $ChildCharges_Array = json_decode($value['ChildCharges'], TRUE);
					$ChildCharges_Array = $value['ChildCharges'];
					if (is_array($ChildCharges_Array) && !empty($ChildCharges_Array)) {
						$ChildCharges_Array_Temp = [];
						foreach ($ChildCharges_Array as $ChildCharges_Array_key => $ChildCharges_Array_value) {
							$ChildCharges_Array_ID = $ChildCharges_Array_value['ID'];
							unset($ChildCharges_Array_value['ID']);
							$ChildCharges_Array_Temp[$ChildCharges_Array_ID] = $ChildCharges_Array_value;
						}

						$ChildCharges_Array_Temp = array_values($ChildCharges_Array_Temp);
						
						foreach ($ChildCharges_Array_Temp as $ChildCharges_Array_Temp_key => &$ChildCharges_Array_Temp_value) {
							$ToursType_Temp = isset($ChildCharges_Array_Temp_value['Type']) 
															? proper($ChildCharges_Array_Temp_value['Type']) 
															: 'Error';
							unset($ChildCharges_Array_Temp_value['Type']);

							/*
							| this line is uncommented because of it 
							| create new array in child price with age

								$value[$ToursType_Temp]['Price']['Child'] = $ChildCharges_Array_Temp_value; 
							*/
							
							$value[$ToursType_Temp]['Price']['Child'] 
										= isset($ChildCharges_Array_Temp_value['Price']) 
										? $ChildCharges_Array_Temp_value['Price'] 
										: 0;
						}
					};
					unset($ChildCharges_Array_Temp_value['Type']);
					unset($value['ChildCharges']);
				};


				// =========================This Getting Images Here=========================

				if (isset($value['Images'])) {
					// $Images_array = json_decode($value['Images'], true);
					$Images_array = $value['Images'];
					$value['Images'] = [];
					if (is_array($Images_array) && !empty($Images_array)) {
						foreach ($Images_array as $Images_array_key => $Images_array_value) {
							
							$imageType = isset($Images_array_value['type']) 
												 ? $Images_array_value['type'] 
												 : '';

							if ($imageType == 'path') {
								$value['Images'][] = urlImage(ifset($Images_array_value['path_or_url']));
							}elseif($imageType == 'url'){
								$value['Images'][] = ifset($Images_array_value['path_or_url']);
							}
						}
					}
					else{
					 $value['Images'] = [urlDefaultImageActivity()];
					}
				}


				// =============================unsetting here=============================

				if (ifsetEqual($value['SicStatus'], 0)) {
					unset($value['Sic']);
				}
				else{
					$value['ToursType'][] = 'Sic';
				}

				unset($value['SicStatus']);

				$boolPrivate = (
					!ifsetEqual($value['PrivateStatus'], 1) 
					&& ifsetEqual($value['PriCabIncl'], 1) 
					&& ifsetEqual($value['CabStatus'], 0)
				);

				if ($boolPrivate) {
					unset($value['Private']);
				}
				else{
					$value['ToursType'][] = 'Private';
				}
				
				unset($value['CabStatus']);
				unset($value['PrivateStatus']);
				unset($value['PriCabIncl']);


			}



			$Activity_Final_Array = [
				"ActivitySearchResult" => [
					"ResponseStatus" => 1,
					
					"Error" => [
						"ErrorCode" => 0,
						"ErrorMessage" => '', 
					],

					// "TraceId" => csrf_token(),
					"Location" => $Location,
					"Date" => $date,
					"ActivityResults" =>$result,
					// "ActivityCombo" =>$Activity_Combo_Array,
				]
			];

			// dd_pre_echo($Activity_Final_Array);

			return $Activity_Final_Array;
		}
		else{
			return [
				"ActivitySearchResult" => [
					"ResponseStatus" => 2,
					"Error" => [
						"ErrorCode" => 0,
						"ErrorMessage" => 'Activity Not Found',
					]
				]
			];
		}

	}

	/*
	| this function is to get activities from self db or cache data 
	| which is stored from other api like viator 
	| params = ["fgf_city_id" => 15180, "viator_city_id" => 10];
	*/	
	public function unionActivities($params)
	{
		$auth = Auth::user();

		$fgfCityId = $params['fgf_city_id'];
		$viatorCityId = $params['viator_city_id'];

		$viatorActivities = DB::connection('mysql2')->table('viator_activities')
												->select([
																'viator_activities.id', 'code', DB::raw('\'v\' as vendor'), 
																'primaryDestinationId as  destinationCode', 
																'currencyCode as currency', 
																'title as name', 
																'shortDescription as  description', 
																'status', 'rank', 'thumbnailURL as image'
															])
															->where(['primaryDestinationId' => $viatorCityId]);

		$agentActivities = DB::connection('mysql2')->table('agent_activities')
												->select([
																'agent_activities.id', DB::raw('CONCAT(\'OWN\', agent_activities.id) AS code, \'OWN\' as vendor'), 
																'destination_code as  destinationCode', 
																DB::raw('\'INR\' as currency'), 
																'title as name', 'description', 
																'status', DB::raw('\'0\' as rank'),
																DB::raw('CONCAT(\''.urlImage().'\', image_path) as image')
															])
															->where([
																		'admin_id' => $auth->admin->id,
																		'destination_code' => $fgfCityId
																	]);

		$finalActivities = DB::connection('mysql2')->table('activities')
											->select([
															'activities.id', DB::raw('CONCAT(prefix, activities.id) AS code, \'f\' as vendor'), 
															'destinationCode', 'currency', 'name', 
															'description', 'activities.status', 'rank',
															DB::raw(
																'(select CONCAT(\''.urlImage().'\', imagePath) 
																	from images 
																	where relationId = CONCAT(activities.prefix, activities.id)  
																	order by id asc limit 1) as image'
															)
														])
													->where(['destinationCode' => $fgfCityId])
														->unionAll($viatorActivities)
															->unionAll($agentActivities)
																->orderBy('rank', 'desc')
																	->offset(0)
                										->limit(50)
																			->get();
		return $finalActivities;
	}


	public function searchActivitiesByName($params, $index = 0, $take = 10)
	{

		$auth = Auth::user();
		$name = $params['name'];
		$fgfCityId = $params['fgf_city_id'];
		$viatorCityId = $params['viator_city_id'];

		$viatorActivities = DB::connection('mysql2')->table('viator_activities')
												->select(['title as name', 'rank'])
													->where([
															'primaryDestinationId' => $viatorCityId,
															['title', 'like', '%'.$name.'%']
														]);

		$agentActivities = DB::connection('mysql2')->table('agent_activities')
												->select(['title as name', DB::raw('\'0\' as rank')])
													->where([
																'admin_id' => $auth->admin->id,
																'destination_code' => $fgfCityId,
																['title', 'like', '%'.$name.'%']
															]);

		$finalActivities = DB::connection('mysql2')->table('activities')
											->select(['name', 'rank'])
													->where([
															'destinationCode' => $fgfCityId,
															['name', 'like', '%'.$name.'%']
														])
														->unionAll($viatorActivities)
															->unionAll($agentActivities)
																->orderBy('rank', 'desc')
																	->skip($index*$take)
																		->take($take)
																			->get();

		return $finalActivities;
	}


	public function searchActivityByName($params, $index = 0, $take = 10)
	{

		$auth = Auth::user();
		$activityNames = [];
		$name = $params['name'];
		$fgfCityId = $params['fgf_city_id'];
		$viatorCityId = $params['viator_city_id'];

		$viatorActivities = DB::connection('mysql2')->table('viator_activities')
												->select([
																'viator_activities.id', 'code', DB::raw('\'v\' as vendor'), 
																'primaryDestinationId as  destinationCode', 
																'currencyCode as currency', 
																'title as name', 
																'shortDescription as  description', 
																'status', 'rank', 'thumbnailURL as image'
															])
													->where([
															'primaryDestinationId' => $viatorCityId,
															'title' => $name
														]);

		$agentActivities = DB::connection('mysql2')->table('agent_activities')
												->select([
																'agent_activities.id', DB::raw('CONCAT(\'OWN\', agent_activities.id) AS code, \'OWN\' as vendor'), 
																'destination_code as  destinationCode', 
																DB::raw('\'INR\' as currency'), 
																'title as name', 'description', 
																'status', DB::raw('\'0\' as rank'),
																DB::raw('CONCAT(\''.urlImage().'\', image_path) as image')
															])
													->where([
																'admin_id' => $auth->admin->id,
																'destination_code' => $fgfCityId,
																'title' => $name
															]);

		$finalActivities = DB::connection('mysql2')->table('activities')
											->select([
															'activities.id', DB::raw('CONCAT(prefix, activities.id) AS code, \'f\' as vendor'), 
															'destinationCode', 'currency', 'name', 
															'description', 'activities.status', 'rank',
															DB::raw(
																'(select CONCAT(\''.urlImage().'\', imagePath) 
																	from images 
																	where relationId = CONCAT(activities.prefix, activities.id)  
																	order by id asc limit 1) as image'
															)
														])
													->where([
															'destinationCode' => $fgfCityId,
															'name' => $name
														])
														->unionAll($viatorActivities)
															->unionAll($agentActivities)
																->orderBy('rank', 'desc')
																	->skip($index*$take)
																		->take($take)
																			->get();
		
		return $finalActivities;
	}


	/*
	| code is the index(id) of this table
	*/
	public function findByCode($id)
	{
		$columns  = [
				'id', 'id as code', 
				'destinationCode', 'currency', 'name', 
				'description', 'status', 'rank',
				DB::raw('(select CONCAT(\''.urlImage().'\', imagePath) 
					from images 
					where relationId = CONCAT(prefix, id)  
					order by id asc limit 2) as image')
			];

		return $this->select($columns)->where(['id' => $id])->first();
	}

}
