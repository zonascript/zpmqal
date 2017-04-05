
{{-- making an object which contain some ids --}}
<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	$datesObject = [];

	foreach ($package->hotelRoutes as $hotelRouteKey  => $hotelRoute) {

		// date object here
		$minDate = date_differences($hotelRoute->start_date, date("Y-m-d"));
		$maxDate = date_differences($hotelRoute->end_date, date("Y-m-d"));

		$datesObject["rid_".$hotelRoute->id] = [
				'startDate' => $hotelRoute->start_datetime->format('d-m-Y'),
				'endDate' => $hotelRoute->end_datetime->format('d-m-Y'),
				'minDate' => $minDate,
				'maxDate' => $maxDate
			];


		// id's object here
		$objectKey = 'activities_'.$hotelRoute->id;

		$idObject[$objectKey] = [
				'did' => $hotelRoute->activities->id,
				'rid' => $hotelRoute->id,
				'next_did' => 'NaN',
				'next_rid' => 'NaN',
				'origin' => $hotelRoute->origin,
				'destination' => $hotelRoute->destination,
			];

		$nexthotelRouteKey = $hotelRouteKey+1;
		
		if ($nexthotelRouteKey < $package->hotelRoutes->count()) {

			$idObject[$objectKey]['next_did'] = $package
																					->hotelRoutes[$nexthotelRouteKey]
																						->activities->id;

			$idObject[$objectKey]['next_rid'] = $package
																					->hotelRoutes[$nexthotelRouteKey]->id;
		}

		$rid[] = $hotelRoute->id;
		$did[] = $hotelRoute->activities->id;
	}

	$idObject['did'] = $did;
	$idObject['rid'] = $rid;
	$idObject = rejson_decode($idObject);

?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
	var datesObject = {!! json_encode($datesObject) !!};

	var modeObj = {
						'' : 'Mode',
						'no' : 'No Transfer', 
						'private' : 'Private',
						'sic' : 'SIC' , 
						'selfdrive' : 'Self Drive'
					};

	var timingObj = {
					'' : 'Timing',
					'morning' : 'Morning', 
					'noon' : 'Noon',
					'evening' : 'Evening' , 
					'halfday' : 'Half Day',
					'fullday' : 'Full Day'
				};
</script>