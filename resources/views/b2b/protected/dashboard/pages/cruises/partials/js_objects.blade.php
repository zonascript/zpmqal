{{-- making an object which contain some ids --}}
<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->cruiseRoutes as $cruiseRouteKey  => $cruiseRoute) {
		$objectKey = 'cruise_'.$cruiseRoute->id;

		$idObject[$objectKey] = [
				'did' => $cruiseRoute->cruise->id,
				'rid' => $cruiseRoute->id,
				'next_did' => 'NaN',
				'next_rid' => 'NaN',
				'origin' => $cruiseRoute->origin,
				'destination' => $cruiseRoute->destination,
			];

		$nestcruiseRouteKey = $cruiseRouteKey+1;
		
		if ($nestcruiseRouteKey < $package->cruiseRoutes->count()) {

			$idObject[$objectKey]['next_did'] = $package
																					->cruiseRoutes[$nestcruiseRouteKey]
																						->cruise->id;

			$idObject[$objectKey]['next_rid'] = $package
																					->cruiseRoutes[$nestcruiseRouteKey]->id;
		}

		$rid[] = $cruiseRoute->id;
		$did[] = $cruiseRoute->cruise->id;
	}

	$idObject['did'] = $did;
	$idObject['rid'] = $rid;
	$idObject = rejson_decode($idObject);
?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>