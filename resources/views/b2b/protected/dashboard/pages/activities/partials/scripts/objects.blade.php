{{-- making an object which contain some ids --}}
<?php 
	$rid =  [];
	$idObject = [];
	$crid = '';
	foreach ($package->hotelRoutes as $hotelRouteKey  => $hotelRoute) {

		if ($hotelRouteKey == 0) $crid = $hotelRoute->id;

		// date object here
		$minDate = date_differences($hotelRoute->start_date, date("Y-m-d"));
		$maxDate = date_differences($hotelRoute->end_date, date("Y-m-d"));

	
		// id's object here
		$objectKey = 'rid_'.$hotelRoute->id;

		$idObject[$objectKey] = [
				'rid' => $hotelRoute->id,
				'nrid' => 'NaN',
				'origin' => $hotelRoute->origin,
				'destination' => $hotelRoute->destination,
				'startDate' => $hotelRoute->start_datetime->format('d-m-Y'),
				'endDate' => $hotelRoute->end_datetime->format('d-m-Y'),
				'minDate' => $minDate,
				'maxDate' => $maxDate
			];

		$nexthotelRouteKey = $hotelRouteKey+1;
		
		if ($nexthotelRouteKey < $package->hotelRoutes->count()) {
			$idObject[$objectKey]['nrid'] = $package
																					->hotelRoutes[$nexthotelRouteKey]->id;
		}

		$rid[] = $hotelRoute->id;
	}

	$idObject['rid'] = $rid;
	$idObject['crid'] = $crid;
	$idObject = rejson_decode($idObject);

?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
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