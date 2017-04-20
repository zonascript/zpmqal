<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->hotelRoutes as $hotelRouteKey  => $hotelRoute) {
		$objectKey = 'hotel_'.$hotelRoute->id;

		$idObject[$objectKey] = [
				'next_did' 		=> 'NaN',
				'next_rid' 		=> 'NaN',
				'elem_id' 		=> $objectKey,
				'rid' 				=> $hotelRoute->id,
				'origin'			=> $hotelRoute->origin,
				'did' 				=> $hotelRoute->hotel->id,
				'destination' => $hotelRoute->destination,
			];

		$nesthotelRouteKey = $hotelRouteKey+1;
		
		if ($nesthotelRouteKey < $package->hotelRoutes->count()) {

			$idObject[$objectKey]['next_did'] = $package
																					->hotelRoutes[$nesthotelRouteKey]
																						->hotel->id;

			$idObject[$objectKey]['next_rid'] = $package
																					->hotelRoutes[$nesthotelRouteKey]->id;
		}

		$rid[] = $hotelRoute->id;
		$did[] = $hotelRoute->hotel->id;
	}

	$idObject['did'] = $did;
	$idObject['rid'] = $rid;
	$idObject = rejson_decode($idObject);
?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>
