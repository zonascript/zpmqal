<?php $imageIndex = 0; ?>
@forelse ($cruiseCabinResult as $cruiseCabinResult_key => $cruiseCabinResult_value)
	{{-- Room Type --}}
	<div class="col-md-12 col-sm-12 col-xs-12 padding-10">
		<div class="col-md-12 col-sm-12 col-xs-12 main-roomContainer nopadding">
			{{-- Room Type Image Div  --}}
			<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
				<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-120px">
					<img src="{{ urlDefaultImageRoom() }}" alt="" height="100%" width="100%">
				</div>
			</div>
			{{-- /Room Type Image Div  --}}

			{{-- Room type main Container --}}
			<div class="col-md-7 col-sm-7 col-xs-12 nopadding">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
						<div class="font-size-20">{{ $cruiseCabinResult_value->roomType }}</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="m-top-10">
							<div class="col-md-12 col-sm-12 col-xs-12 nopadding border-bottom-gray">
								{{-- inclusion --}}
								<div class="col-md-12 col-sm-12 col-xs-12">
									<b>Inclusion : </b>
									{{-- @if (strlen(implode(', ', $cruiseCabinResult_value['Inclusions'])) > 0)
										{{ sub_string(implode(', ', $cruiseCabinResult_value['Inclusions']), 50) }}
										@if (strlen(implode(', ', $cruiseCabinResult_value['Inclusions'])) > 50 )
											<button id="btn-inclusionMore" class="btn-link cursor-pointer nopadding" 
												data-toggle="modal" data-target=".bs-example-modal-sm" 
												data-title="Inclusion" data-bodyid="inclusionList{{ $requestIndex.'_'.$cruiseCabinResult_key }}" 
												data-button="false">More
											</button>
										@endif

										@else
											Room Only
											<div class="row m-top-20"></div>
											<div class="row m-top-10"></div>
									@endif
									<div id="inclusionList{{ $requestIndex.'_'.$cruiseCabinResult_key }}" hidden>
										<ul>
											@forelse ($cruiseCabinResult_value['Inclusions'] as $inclusion)
												<li>{{ $inclusion }}</li>
											@empty
												<li>No Inclusions </li>
											@endforelse
										</ul>
									</div> --}}
								</div>
								{{-- /inclusion --}}
								{{-- Amenities 
								<div class="col-md-12 col-sm-12 col-xs-12">
									@if (sub_string(implode(', ', $cruiseCabinResult_value['Amenities']), 50) != sub_string(implode(', ', $cruiseCabinResult_value['Inclusions']), 50))
										<b>Amenities : </b>
										{{ sub_string(implode(', ', $cruiseCabinResult_value['Amenities']), 50) }}
										@if (strlen(implode(', ', $cruiseCabinResult_value['Amenities'])) > 50 )
											<button id="btn-amenitiesMore" class="btn-link cursor-pointer" 
												data-toggle="modal" data-target=".bs-example-modal-sm" 
												data-title="Amenities" data-bodyid="amenitiesList{{ $requestIndex.'_'.$cruiseCabinResult_key }}" 
												data-button="false">More
											</button>
										@else
										@endif
										<div id="amenitiesList{{ $requestIndex.'_'.$cruiseCabinResult_key }}" hidden>
											<ul>
												@forelse ($cruiseCabinResult_value['Amenities'] as $amenities)
													<li>{{ $amenities }}</li>
												@empty
													<li>No Inclusions </li>
												@endforelse
											</ul>
										</div>
									@else
										
									@endif
								</div>
								/Amenities --}}
							</div>
							{{-- Price breakup and cancel --}}
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
								<div class="col-md-4 col-sm-4 col-xs-12">
									<button class="btn-link cursor-pointer nopadding" data-toggle="modal" data-target=".bs-example-modal-lg" data-title="Price break-up" data-bodyid="priceBreakupBody{{ $requestIndex.'_'.$cruiseCabinResult_key }}" data-button="false">Price Break-Up</button>
									<div id="priceBreakupBody{{ $requestIndex.'_'.$cruiseCabinResult_key }}" hidden>
										{{-- @if (isset($cruiseCabinResult_value['PriceBreakUp']))
											<table class="table table-bordered">
	                      <thead class="table-thead">
	                        <tr>
	                          <th>For</th>
	                          <th>Price</th>
	                        </tr>
	                      </thead>
	                      <tbody>
													@forelse($cruiseCabinResult_value['PriceBreakUp'] as $priceBreakUp_key => $priceBreakUp)
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
										@endif --}}
									</div>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-12">
									<span id="pipeSapr"> | </span>
								</div>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<button class="btn-link cursor-pointer nopadding" data-toggle="modal" data-target=".bs-example-modal-lg" data-title="Price break-up" data-bodyid="cancellationPolicyBody{{ $requestIndex.'_'.$cruiseCabinResult_key }}" data-button="false">Cancellation Policy</button>
									<div id="cancellationPolicyBody{{ $requestIndex.'_'.$cruiseCabinResult_key }}" hidden>
										{{-- {{ $cruiseCabinResult_value['CancellationPolicy'] }} --}}
									</div>
								</div>
							</div>
							{{-- /Price breakup and cancel --}}
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
								</i><span>{{ $cruiseCabinResult_value->promotionRoomPrice != '' ? $cruiseCabinResult_value->promotionRoomPrice : $cruiseCabinResult_value->roomPrice }}</span>
							</h3>
						</div>
						<div class="m-top-20">
							<button class="btn btn-block btn-primary btn-bookRoom" data-bookIndex="{{ $cruiseCabinResult_key }}">Book</button>
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
	{{-- {{ pre_echo($error) }} --}}
@endforelse
