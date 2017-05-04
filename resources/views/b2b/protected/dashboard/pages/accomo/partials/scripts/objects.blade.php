<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->accomoRoutes as $accomoRouteKey  => $accomoRoute) {
		$objectKey = 'rid_'.$accomoRoute->id;
		$fid = '';
		$fdid = '';
		$accomoProps = [];

		if (!is_null($accomoRoute->fusion)) {
			$fdid = $accomoRoute->fusion->id;
			if($accomoRoute->mode == 'hotel'){
				$fid = $accomoRoute->fusion->hotel_code;
				foreach ($accomoRoute->fusion->packageRooms as $packageRoom) {
					$selRooms = ['id' => $packageRoom->id, 'vdr' => $packageRoom->vendor];
					$accomoProps[$packageRoom->roomtype_code] = $selRooms;
				}
			}
			elseif ($accomoRoute->mode == 'cruise') {
				$fid = $accomoRoute->fusion->cruise_code;
				foreach ($accomoRoute->fusion->packageCabins as $packageCabins) {
					$selCabins = ['id' => $packageCabins->id, 'vdr' => $packageCabins->vendor];
					$accomoProps[$packageCabins->cabintype_code] = $selCabins;
				}
			}
		}

		$idObject[$objectKey] = [
				'fid' 				=> $fid,
				'nrid' 				=> 'NaN',
				'fdid' 				=> $fdid,
				'elem_id' 		=> $objectKey,
				'props'				=> $accomoProps,
				'rid' 				=> $accomoRoute->id,
				'mode'				=> $accomoRoute->mode,
				'origin'			=> $accomoRoute->origin,
				'destination' => $accomoRoute->destination,
			];

		$nextAccomoRouteKey = $accomoRouteKey+1;
		
		if ($nextAccomoRouteKey < $package->accomoRoutes->count()) {
			$idObject[$objectKey]['nrid'] = $package
																					->accomoRoutes[$nextAccomoRouteKey]->id;
		}
		
		$rid[] = $accomoRoute->id;
	}

	$idObject['rid'] = $rid;
	$idObject['crid'] = $package->accomoRoutes[0]->id;
	$idObject = rejson_decode($idObject);
?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>
