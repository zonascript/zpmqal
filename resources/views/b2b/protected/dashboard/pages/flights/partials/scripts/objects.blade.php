
{{-- making an object which contain some ids --}}
<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->flightRoutes as $flightRouteKey  => $flightRoute) {
		$objectKey = 'flight_'.$flightRoute->id;

		$idObject[$objectKey] = [
				'did' => $flightRoute->flight->id,
				'rid' => $flightRoute->id,
				'next_did' => 'NaN',
				'next_rid' => 'NaN',
				'origin' => $flightRoute->origin,
				'destination' => $flightRoute->destination,
			];

		$nestFlightRouteKey = $flightRouteKey+1;
		
		if ($nestFlightRouteKey < $package->flightRoutes->count()) {

			$idObject[$objectKey]['next_did'] = $package
																					->flightRoutes[$nestFlightRouteKey]
																						->flight->id;

			$idObject[$objectKey]['next_rid'] = $package
																					->flightRoutes[$nestFlightRouteKey]->id;
		}

		$rid[] = $flightRoute->id;
		$did[] = $flightRoute->flight->id;
	}

	$idObject['did'] = $did;
	$idObject['rid'] = $rid;
	$idObject = rejson_decode($idObject);
?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>