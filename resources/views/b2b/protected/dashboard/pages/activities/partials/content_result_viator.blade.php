@if (isset($activitiesSlice->viatorActivities->data))
<div class="row">
	<ul class="list list-unstyled">
		@foreach($activitiesSlice->viatorActivities->data as $viatorActivityResult_key => $viatorActivityResult)
			{{-- working in php tag --}}
			<?php 
				$activityCode = ifset($viatorActivityResult->code);

				$isSetActivity = isset($activitiesSlice->selectedActivities->$activityCode);

				$date = ifset($activitiesSlice->selectedActivities->$activityCode->date);
				
				$adultCount = isset($activitiesSlice->selectedActivities->$activityCode->adultCount) 
					? $activitiesSlice->selectedActivities->$activityCode->adultCount
					: ifset($activitiesSlice->noOfPax->NoOfAdults);

				$childCount = isset($activitiesSlice->selectedActivities->$activityCode->childCount) 
					? $activitiesSlice->selectedActivities->$activityCode->childCount
					: ifset($activitiesSlice->noOfPax->NoOfChild);

				$viatorActivityPrice = ifset($viatorActivityResult->price);
				$viatorActivityPrice = $adultCount*$viatorActivityPrice 
														 + $childCount*$viatorActivityPrice*.60;

				$viatorActivityUniqueCode = $activitiesSlice_key.'_'.$viatorActivityResult_key;

			?>
			{{-- /working in php tag --}}

			<li class="min-height-110px">
				<div class="m-top-10">
					<div id="container_v_{{ $viatorActivityUniqueCode }}" class="x_panel glowing-border nopadding activityContainer {{ $isSetActivity ? 'border-green-3px' : '' }}" data-activityCode="{{ $activityCode }}" data-Index="{{ $viatorActivityResult_key }}" data-mainIndex="{{ $activitiesSlice->model->id }}" data-vendor="viator">
						<div class="col-md-10 col-sm-10 col-xs-12 nopadding">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row height-165px">
									<img src="{{ ifset($viatorActivityResult->thumbnailURL, urlDefaultImageActivity()) }}" alt="" height="100%" width="100%">
								</div>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h2>{{ ifset($viatorActivityResult->shortTitle) }}</h2>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<span id="activitySortDescription_v_{{ $viatorActivityUniqueCode }}">
										{!! sub_string(strip_tags(ifset($viatorActivityResult->shortDescription)), ($isSetActivity ? 90 : 600)) !!}
									</span>
									@if (strlen(ifset($viatorActivityResult->shortDescription)) != '')
										<button id="btn-descriptionMore_v_{{ $viatorActivityUniqueCode }}" 
											class="btn-link cursor-pointer nopadding" 
											data-toggle="modal" data-target=".bs-example-modal-lg" 
											data-title="{{ ifset($viatorActivityResult->shortTitle) }} : Description" data-bodyid="activityFullDescription_v_{{ $viatorActivityUniqueCode }}" 
											data-button="false" data-Index="{{ $viatorActivityUniqueCode }}">More
										</button>
									@endif

									<div id="activityFullDescription_v_{{ $viatorActivityUniqueCode }}" hidden>
										{!! ifset($viatorActivityResult->shortDescription) !!}
									</div>
								</div>
								<div id="inputContainer_v_{{ $viatorActivityUniqueCode }}" style="{{ $isSetActivity ? '' : 'display: none;' }}">
									{{-- date and pax --}}
									<div>
										{{-- Date --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
												<input type="text" placeholder="Date" value="{{ $date }}" name="ActivityDate"
													class="form-control has-feedback-left datepicker datepicker-{{ $activitiesSlice_key }} p-left-10" 
													aria-describedby="inputSuccess2Status3" 
													data-startDate="{{ $startDate }}" 
													data-minDate="{{date_differences($startDate,date("Y-m-d"))}}" 
													data-maxDate="{{date_differences($endDate,date("Y-m-d"))}}" 
												/>
												<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
											</div>
										</div>
										{{-- /Date --}}

										{{-- Adult Button --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
												<div class="center">
													<div class="input-group">
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray" data-type="minus" data-field="adult_v_{{ $viatorActivityUniqueCode }}" data-name="adult" data-Index="{{ $viatorActivityUniqueCode }}" data-vendor="viator">
																<span class="glyphicon glyphicon-minus"></span>
															</button>
														</span>
														<span class="form-control text-center nopadding-right">
															<span id="a_value">
																<input type="text" id="adult_v_{{ $viatorActivityUniqueCode }}" name="adult_v_{{ $viatorActivityUniqueCode }}" class="width-15 nostyle input-number adult" value="{{ $adultCount }}" min="1" max="10" disabled="disabled">
															</span>
															<span id="a_word" name="adult_v_{{ $viatorActivityUniqueCode }}">Adult</span>
														</span>
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="adult_v_{{ $viatorActivityUniqueCode }}" data-name="adult" data-Index="{{ $viatorActivityUniqueCode }}" data-vendor="viator">
																<span class="glyphicon glyphicon-plus"></span>
															</button>
														</span>
													</div>
												</div>
											</div>
										</div>
										{{-- /Adult Button --}}
										
										{{-- Child Button --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
												<div class="center">
													<div class="input-group">
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray" data-type="minus" data-field="child_v_{{ $viatorActivityUniqueCode }}" data-name="child" data-Index="{{ $viatorActivityUniqueCode }}" data-vendor="viator">
																<span class="glyphicon glyphicon-minus"></span>
															</button>
														</span>
														<span class="form-control text-center nopadding-right">
															<span id="a_value">
																<input type="text" id="child_v_{{ $viatorActivityUniqueCode }}" name="child_v_{{ $viatorActivityUniqueCode }}" class="width-15 nostyle input-number child" value="{{ $childCount }}" min="0" max="12" disabled="disabled">
															</span>
															<span id="c_word" name="child_v_{{ $viatorActivityUniqueCode }}">Child</span>
														</span>
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="child_v_{{ $viatorActivityUniqueCode }}" data-name="child" data-Index="{{ $viatorActivityUniqueCode }}" data-vendor="viator">
																<span class="glyphicon glyphicon-plus"></span>
															</button>
														</span>
													</div>
												</div>
											</div>
										</div>
										{{-- /Child Button --}}
									</div>
									{{-- /date and pax --}}

								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<div class="height-150px vertical-parent">
								<div class="vertical-child">
									<h2><span class="currency">{{ $viatorActivityResult->currencyCode }}</span> 
										<span id="activityPrice_v_{{ $viatorActivityUniqueCode }}" class="activityPrice" data-price="{{ ifset($viatorActivityResult->price) }}">{{ $viatorActivityPrice }}</span>
									</h2> 
									<div class="m-top-30">
										<button 
											class="btn {{ $isSetActivity ? 'btn-danger' : 'btn-primary' }} btn-block btn-activitySelect" 
											data-Index="{{ $viatorActivityUniqueCode }}"
											data-uniqueid="v_{{ $viatorActivityUniqueCode }}" 
											data-selected="0">{{ $isSetActivity ? 'Remove' : 'Add' }}
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		@endforeach
	</ul>
</div>
@else
{{-- <p>No Activity Found</p> --}}
@endif
