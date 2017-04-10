
	public function findpackageCruise($packageDbId, $packageCruiseId, $checkOnly = false)
	{
		$auth = Auth::user();
		$packageCruise = PackageCruiseModel::select()
									->where([
											"id" => $packageCruiseId,
											"package_id" => $packageDbId,
											"user_id" => $auth->id,
										])
									->get();

		if ($packageCruise->count() >= 1) {
			return $checkOnly ? true : $packageCruise[0];
		}
		else{
			return $packageCruise;
		}

	}

	public function enquiryExist($packageDbId, $packageCruiseId){
		$result = $this->findpackageCruise($packageDbId, $packageCruiseId, true);
		return $result ? true : false;
	}

	public function allEnquiry($id, $packageDbId, $colunm = '*'){
		$auth = Auth::user();

		if (PackageController::call()->validPackage($id, $packageDbId)) {
			$packageCruise = PackageCruiseModel::select($colunm)
										->where([
												"package_id" => $packageDbId,
												"user_id" => $auth->id,
											])
										->get();

			return $packageCruise->count() >= 1 ? $packageCruise : false;
		}
		else{
			return false;
		}
	}


	public function nextCart($id, $packageDbId, $packageCruiseId){
		// $packageCruiseId is the current id
		$allEnquiry = $this->allEnquiry($id, $packageDbId, ["id","package_id"]);
		
		$i = 0;

		if ($allEnquiry && $allEnquiry->count() > 1 ) {
			foreach ($allEnquiry as $key => $value) {
				if ($i == 1) {
					return $value->id;
					break;
				};

				$i = $value->id == $packageCruiseId ? 1 : 0;
			}
		}else{
			return false;
		}
	}


	public function getCruises($id, $packageDbId, $packageCruiseId)
	{

		$getCurrentCart = $this->findpackageCruise($packageDbId, $packageCruiseId);

		if (ClientController::call()->validClient($id) && $getCurrentCart->count() > 0) {
			
			// getting menus data like cruises, flight, cabs 
			$menus = MenusController::call()->getPackageMenus($packageDbId);
			// dd_pre_echo($menus);

			// fatching destination from db here
			$destination = DestinationController::call()->find($getCurrentCart->city_id);
			// dd($destination);
			$roomGuests = getPax(json_decode($getCurrentCart->room_guests));

			// this is global request array
			$requestArray = [
				"checkInDate" => $getCurrentCart->check_in_date,
				"city_id" => $destination->fgf_destinationcode,
				"nights" => $getCurrentCart->nights,
				"adultCount" => $roomGuests->NoOfAdults,
				"childAge" => $roomGuests->ChildAge, 
				"minRating" => 1,
				"maxRating" => 5,
				"PreferredCurrency" => "INR",
			];

			$cruiseResults = CruiseController::call()->cruise($requestArray);

			// inserting cruise data in db
			$getCurrentCart->temp_fgf_cruise_result = json_encode($cruiseResults);

			// saving cruise data in db here
			$getCurrentCart->save();

			// ----------------- Geting all cruise form database ---------------//
			$client = ClientController::call()->info($id);

			// blade data here
			$bladeData = [
				"client" => $client,
				"cartData" => nested_jsonDecode(rejson_decode($getCurrentCart)),
				"urlVariable" => (object)[
					"id" => $id,
					"packageId" => 'FGF'.str_pad($packageDbId, 5, '0', STR_PAD_LEFT),
					"packageDbId" => $packageDbId, 
					"packageCrusiesId" => $packageCruiseId,
				],
				"menus" => $menus,
				"cruiseResults" => $cruiseResults
			];

			// dd_pre_echo($bladeData);
			
			return view('b2b.protected.dashboard.pages.cruise.index', $bladeData);

		}
		else{
			return view('errors.404');
		}
	}

	/* 
	|$id : this is index of clients table,
	|$packageId : this is Package Id for client,
	|$upadateId : that id which indicate how many working done on the package
	|$cartId : this is the index of package_cruise
	*/

	public function getCruiseCabin($id, $packageDbId, $packageCruiseId, Request $request)
	{

		$getCurrentCart = $this->findpackageCruise($packageDbId, $packageCruiseId);

		if (ClientController::call()->validClient($id) && $getCurrentCart->count() > 0) {
			// dd_pre_echo($getCurrentCart);
			$cruiseResults = json_decode($getCurrentCart->temp_fgf_cruise_result);

			$roomGuests = getPax(json_decode($getCurrentCart->room_guests));

			$selectedCruise = $cruiseResults[$request->Index];

			$params = [
				"resultIndex" => $selectedCruise->resultIndex,
				"checkInDate" => $getCurrentCart->check_in_date,
				"nights" => $getCurrentCart->nights,
				"adultCount" => $roomGuests->NoOfAdults,
				"childAge" => $roomGuests->ChildAge, 
				"minRating" => 1,
				"maxRating" => 5
			];

			$cruiseCabinResult = CruiseController::call()->cruiseCabin($params);

			$selectedCruise->cabin = $cruiseCabinResult;

			$getCurrentCart->temp_fgf_cabin_result = json_encode($selectedCruise);
			$getCurrentCart->save();

			$bladeData = [
					"requestIndex" => $request->Index, 
					"cruiseCabinResult" => $cruiseCabinResult,
				];

			return view('b2b.protected.dashboard.pages.cruise.partials.content_cruise_cabin', $bladeData);

		}
		else{
			return false;
		}
	}

	/* 
	| "$statusActive" is showing if you status active or not
	*/

	public function getAllCruises($packageDbId, $statusActive = true){

		$cruisesData = $this->cruisesRow($packageDbId);

		// dd_pre_echo($cruisesData);

		$bookedCruise = (object)[
			"count" => false, 
			"totalCost" => (object)[
					"inInr" => 0,"allCurrency" => (object)[]
				], 
			"cruisesResult" => []
		];

		$selectedCabin = [];

		if (count($cruisesData) >= 1) {
			foreach ($cruisesData as $cruiseData) {

					
				if (ifset($cruiseData->selected_cabin, 0)) {
					
					$selectedCabin = $cruiseData->selected_cabin;
					
					/*====================counting total selected cruise====================*/
					$bookedCruise->count +=  1;
					
					/*===================this is package_cruises table id===================*/
					$selectedCabin->checkInDate = $cruiseData->check_in_date;
					
					$selectedCabin->checkOutDate 
								= addDaysinDate($cruiseData->check_in_date,$cruiseData->nights);

					$selectedCabin->this_id = $cruiseData->id;
					$selectedCabin->route_id = $cruiseData->route_id;
					
					/*=====================getting cruise currency here=====================*/
					$PreferredCurrency = ifset($selectedCabin->PreferredCurrency, "INR");

					$roomPrice = ifset($selectedCabin->roomPrice, 0);
					$promotionRoomPrice = ifset($selectedCabin->promotionRoomPrice, 0);
					
					$selectedCabinPrice = $promotionRoomPrice != 0 
															? $promotionRoomPrice : $roomPrice;

					if (isset($bookedCruise->totalCost->allCurrency->$PreferredCurrency)) {
						$bookedCruise->totalCost->allCurrency->$PreferredCurrency += $selectedCabinPrice;
					}else{
						$bookedCruise->totalCost->allCurrency->$PreferredCurrency = $selectedCabinPrice;
					}

					/*======================pushing cruise result here======================*/
					$bookedCruise->cruisesResult[] = $selectedCabin;
				}
			}

			/*=========================pushing INR Cost here=========================*/
			$bookedCruise->totalCost->inInr = 
				ceil(getInrCost(rejson_decode(ifset($bookedCruise->totalCost->allCurrency, []), true)));
		};

		return $bookedCruise;
	}



	/*
	| this function is making to get complete full row of db using 
	| packageDbId which is package_id of package_cruise table 
	*/

	public function cruisesRow($packageDbId, $statusActive = true, $column = "*")
	{
		$activeWhere = $statusActive ? "`status` = 'Active' OR " : '';
		$result =  PackageCruiseModel::select($column)
					->whereraw("`package_id` = '$packageDbId' AND ($activeWhere `status` = 'occupied')")
					->get();
		return nested_jsonDecode(makeObject($result));
	}
