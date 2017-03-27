<div id="roomresult-{{ $uniqueKey }}" class="row">
	{{-- Hotel Rooms --}}
	@if ($hotelRoom->rooms->GetHotelRoomResult->ResponseStatus == 1)
		<?php $imageIndex = 0; ?>
		@forelse ($hotelRoom->rooms->GetHotelRoomResult->HotelRoomsDetails as $hotelRoom_key => $hotelRoom_value)
			<?php 
				$imageCount = count($hotelRoom->detail->HotelInfoResult->HotelDetails->Images); 
				
				// resetting to 0 if count got full to running into loop
				if($imageIndex == $imageCount-1){
					$imageIndex = 0;
				}

				$imageUrl = ifset($hotelRoom
										->detail->HotelInfoResult
											->HotelDetails->Images[$imageIndex], 
												urlDefaultImageRoom());

				$imageIndex++;
			?>
			{{-- Room Type --}}
			<div class="col-md-12 col-sm-12 col-xs-12 padding-10">
				<div class="col-md-12 col-sm-12 col-xs-12 main-roomContainer nopadding">
					{{-- Room Type Image Div  --}}
					<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
						<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-120px">
							<img src="{{ $imageUrl }}" alt="" height="100%" width="100%">
						</div>
					</div>
					{{-- /Room Type Image Div  --}}

					{{-- Room type main Container --}}
					<div class="col-md-7 col-sm-7 col-xs-12 nopadding">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
								<div class="font-size-20">{{ $hotelRoom_value->RoomTypeName }}</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="m-top-10">
									<div class="col-md-12 col-sm-12 col-xs-12 nopadding border-bottom-gray">
										{{-- inclusion --}}
										<div class="col-md-12 col-sm-12 col-xs-12">
											<b>Inclusion : </b>
											@if (strlen(implode(', ', $hotelRoom_value->Inclusions)) > 0)
												{{ sub_string(implode(', ', $hotelRoom_value->Inclusions), 50) }}
												@if (strlen(implode(', ', $hotelRoom_value->Inclusions)) > 50 )
													<button id="btn-inclusionMore" class="btn-link cursor-pointer nopadding" 
														data-toggle="modal" data-target=".bs-example-modal-sm" 
														data-title="Inclusion" data-bodyid="inclusionList{{ $requestIndex.'_'.$hotelRoom_key }}" 
														data-button="false">More
													</button>
												@endif

												@else
													Room Only
													<div class="row m-top-20"></div>
													<div class="row m-top-10"></div>
											@endif
											<div id="inclusionList{{ $requestIndex.'_'.$hotelRoom_key }}" hidden>
												<ul>
													@forelse ($hotelRoom_value->Inclusions as $inclusion)
														<li>{{ $inclusion }}</li>
													@empty
														<li>No Inclusions </li>
													@endforelse
												</ul>
											</div>
										</div>
										{{-- /inclusion --}}
										{{-- Amenities --}}
										<div class="col-md-12 col-sm-12 col-xs-12">
											@if (sub_string(implode(', ', $hotelRoom_value->Amenities), 50) != sub_string(implode(', ', $hotelRoom_value->Inclusions), 50))
												<b>Amenities : </b>
												{{ sub_string(implode(', ', $hotelRoom_value->Amenities), 50) }}
												@if (strlen(implode(', ', $hotelRoom_value->Amenities)) > 50 )
													<button id="btn-amenitiesMore" class="btn-link cursor-pointer" 
														data-toggle="modal" data-target=".bs-example-modal-sm" 
														data-title="Amenities" data-bodyid="amenitiesList{{ $requestIndex.'_'.$hotelRoom_key }}" 
														data-button="false">More
													</button>
												@else
												@endif
												<div id="amenitiesList{{ $requestIndex.'_'.$hotelRoom_key }}" hidden>
													<ul>
														@forelse ($hotelRoom_value->Amenities as $amenities)
															<li>{{ $amenities }}</li>
														@empty
															<li>No Inclusions </li>
														@endforelse
													</ul>
												</div>
											@else
												
											@endif
										</div>
										{{-- /Amenities --}}
									</div>
									{{-- Price breakup and cancel --}}
									<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
										<div class="col-md-4 col-sm-4 col-xs-12">
											<button class="btn-link cursor-pointer nopadding" data-toggle="modal" data-target=".bs-example-modal-lg" data-title="Price break-up" data-bodyid="priceBreakupBody{{ $requestIndex.'_'.$hotelRoom_key }}" data-button="false">Price Break-Up</button>
											<div id="priceBreakupBody{{ $requestIndex.'_'.$hotelRoom_key }}" hidden>
												@if (isset($hotelRoom_value->Price))
													<table class="table table-bordered">
			                      <thead class="table-thead">
			                        <tr>
			                          <th>For</th>
			                          <th>Price</th>
			                        </tr>
			                      </thead>
			                      <tbody>
															@forelse($hotelRoom_value->Price as $priceBreakUp_key => $priceBreakUp)
																<tr>
				                          <th scope="row">{{ $priceBreakUp_key }}</th>
				                          <td>{{ bool_array($priceBreakUp) ? implode('|', $priceBreakUp) : $priceBreakUp }}</td>
				                        </tr>
				                      @empty
				                      	<tr>
				                      		<td colspan="2">No Price Break Up</td>
				                      	</tr>
															@endforelse
			                     </tbody>
													</table>
												@endif
											</div>
										</div>
										<div class="col-md-1 col-sm-1 col-xs-12">
											<span id="pipeSapr"> | </span>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<button class="btn-link cursor-pointer nopadding" data-toggle="modal" data-target=".bs-example-modal-lg" data-title="Price break-up" data-bodyid="cancellationPolicyBody{{ $requestIndex.'_'.$hotelRoom_key }}" data-button="false">Cancellation Policy</button>
											<div id="cancellationPolicyBody{{ $requestIndex.'_'.$hotelRoom_key }}" hidden>
												{{ $hotelRoom_value->CancellationPolicy }}
											</div>
										</div>
									</div>
									{{-- /Price breakup and cancel --}}
									
									<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<div class="checkbox">
														<label class="nopadding width-100-p">
															<input type="checkbox" class="flat" data-type="pick_up">
														</label>
													</div>
												</div>
												<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Pick-Up</div>
												<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
													<select class="btn-block border-gray padding-5 h-pick-up"
														data-selected="0">
														<option value="">Pick-Up From?</option>
														<option value="airport">Airport</option>
														<option value="hotel">Hotel</option>
														<option value="cruise">Cruise/Ferry</option>
													</select>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<div class="checkbox">
														<label class="nopadding width-100-p">
															<input type="checkbox" class="flat" data-type="drop_off">
														</label>
													</div>
												</div>
												<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Drop-Off</div>
												<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
													<select class="btn-block border-gray padding-5 h-drop-off" 
														data-selected="0">
														<option value="">Drop Off To?</option>
														<option value="airport">Airport</option>
														<option value="hotel">Hotel</option>
														<option value="cruise">Cruise/Ferry</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2 col-sm-2 col-xs-12 nopadding">
						<div class="m-top-10">
							<div class="col-md-12 col-sm-12 col-xs-12 pull-right">
								<div>
									<h3 class="text-center">
										<i class="fa fa-rupee font-size-20">
										</i><span>{{ $hotelRoom_value->Price->PublishedPriceRoundedOff }}</span>
									</h3>
								</div>
								<div class="m-top-20">
									<button class="btn btn-block btn-primary btn-bookRoom" data-tk="{{ $hotelRoom_key }}" data-vendor="tbtq">Add to Cart</button>
								</div>
							</div>
						</div>
					</div>
					{{-- /Room type main Container --}}
				</div>
			</div>
			{{-- /Room Type --}}
		@empty
			<pre class="text-center">
				<h1>No Room Found</h1>
				<p>Please try to refreash the page</p>
			</pre>
		@endforelse
	@else
		<p>No Result Found</p>
	@endif
	{{-- /Hotel Rooms --}}
</div>