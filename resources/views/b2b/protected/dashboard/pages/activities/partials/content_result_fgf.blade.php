@if (isset($activitiesSlice->fgfActivities->ActivitySearchResult->ActivityResults))
<div class="row">
	<ul class="list list-unstyled">
		@foreach($activitiesSlice->fgfActivities->ActivitySearchResult->ActivityResults as $ActivityResult_key => $ActivityResult)
			{{-- working in php tag --}}
			<?php 

				$activityCode = ifset($ActivityResult->ActivityCode);
				$isSetActivity = isset($activitiesSlice->selectedActivities->$activityCode);
				$date = ifset($activitiesSlice->selectedActivities->$activityCode->date);
				
				$adultCount = isset($activitiesSlice->selectedActivities->$activityCode->adultCount) 
					? $activitiesSlice->selectedActivities->$activityCode->adultCount
					: ifset($activitiesSlice->noOfPax->NoOfAdults);

				$childCount = isset($activitiesSlice->selectedActivities->$activityCode->childCount) 
					? $activitiesSlice->selectedActivities->$activityCode->childCount
					: ifset($activitiesSlice->noOfPax->NoOfChild);

				$fgfActivityUniqueCode = $activitiesSlice_key.'_'.$ActivityResult_key;

				$fgfTourType = isset($activitiesSlice->selectedActivities->$activityCode->tourType) ? $activitiesSlice->selectedActivities->$activityCode->tourType : '';
			?>
			{{-- /working in php tag --}}

			<li class="min-height-110px">
				<div class="m-top-10">
					<div id="container_{{ $fgfActivityUniqueCode }}" class="x_panel glowing-border nopadding activityContainer {{ $isSetActivity ? 'border-green-3px' : '' }}" data-activityCode="{{ ifset($ActivityResult->ActivityCode) }}" data-Index="{{ $ActivityResult_key }}" data-mainIndex="{{ $activitiesSlice->model->id }}" data-vendor="fgf">
						<div class="col-md-10 col-sm-10 col-xs-12 nopadding">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row height-165px">
									<img src="{{ ifset($ActivityResult->Images[0], urlDefaultImageActivity()) }}" alt="" height="100%" width="100%">
								</div>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h2>{{ ifset($ActivityResult->ActivityName) }}</h2>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<span id="activitySortDescription_{{ $fgfActivityUniqueCode }}">
										{{ sub_string(ifset($ActivityResult->Description), ($isSetActivity ? 90 : 600)) }}
									</span>
									@if (strlen(ifset($ActivityResult->Description)) != '')
										<button id="btn-descriptionMore_{{ $fgfActivityUniqueCode }}" 
											class="btn-link cursor-pointer nopadding" 
											data-toggle="modal" data-target=".bs-example-modal-lg" 
											data-title="{{ ifset($ActivityResult->ActivityName) }} : Description" data-bodyid="activityFullDescription_{{ $fgfActivityUniqueCode }}" 
											data-button="false" data-Index="{{ $fgfActivityUniqueCode }}">More
										</button>
									@endif

									<div id="activityFullDescription_{{ $fgfActivityUniqueCode }}" hidden>
										{{ ifset($ActivityResult->Description) }}
									</div>
								</div>
								<div id="inputContainer_{{ $fgfActivityUniqueCode }}" style="{{ $isSetActivity ? '' : 'display: none;' }}">
									{{-- date and pax --}}
									<div>
										{{-- Date --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
												<input type="text" placeholder="Date" value="{{$date}}" name="ActivityDate"
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
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray" data-type="minus" data-field="adult_{{ $fgfActivityUniqueCode }}" data-name="adult" data-Index="{{ $fgfActivityUniqueCode }}" data-vendor="fgf">
																<span class="glyphicon glyphicon-minus"></span>
															</button>
														</span>
														<span class="form-control text-center nopadding-right">
															<span id="a_value">
																<input type="text" id="adult_{{ $fgfActivityUniqueCode }}" name="adult_{{ $fgfActivityUniqueCode }}" class="width-15 nostyle input-number adult" value="{{ $adultCount }}" min="1" max="10" disabled="disabled">
															</span>
															<span id="a_word" name="adult_{{ $fgfActivityUniqueCode }}">Adult</span>
														</span>
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="adult_{{ $fgfActivityUniqueCode }}" data-name="adult" data-Index="{{ $fgfActivityUniqueCode }}" data-vendor="fgf">
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
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray" data-type="minus" data-field="child_{{ $fgfActivityUniqueCode }}" data-name="child" data-Index="{{ $fgfActivityUniqueCode }}" data-vendor="fgf">
																<span class="glyphicon glyphicon-minus"></span>
															</button>
														</span>
														<span class="form-control text-center nopadding-right">
															<span id="a_value">
																<input type="text" id="child_{{ $fgfActivityUniqueCode }}" name="child_{{ $fgfActivityUniqueCode }}" class="width-15 nostyle input-number child" value="{{ $childCount }}" min="0" max="12" disabled="disabled">
															</span>
															<span id="c_word" name="child_{{ $fgfActivityUniqueCode }}">Child</span>
														</span>
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="child_{{ $fgfActivityUniqueCode }}" data-name="child" data-Index="{{ $fgfActivityUniqueCode }}" data-vendor="fgf">
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

									{{-- if sic and private exist --}}
									<div>
										{{-- Date --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback nopadding">
												<select name="" id="tourType_{{ $fgfActivityUniqueCode }}" class="form-control has-feedback p-left-10 tourType" data-Index="{{ $fgfActivityUniqueCode }}">
													{{-- <option value="">Select Type?</option> --}}
													@foreach ($ActivityResult->ToursType as $ToursType)
														<?php 
															$selectedTourType = isset($activitiesSlice->selectedActivities->$activityCode->tourType)
																? $activitiesSlice->selectedActivities->$activityCode->tourType 
																: 'sic';
														?>
														<option value="{{ strtolower($ToursType) }}" 
														data-Adult="{{ isset($ActivityResult->$ToursType->Price->Adult) ? $ActivityResult->$ToursType->Price->Adult : '' }}" 
														data-Child="{{ isset($ActivityResult->$ToursType->Price->Child) ? $ActivityResult->$ToursType->Price->Child : '' }}" 
														data-car="{{ isset($ActivityResult->Private->Cars) && bool_array($ActivityResult->Private->Cars) ? 1 : 0 }}" 
														{{strtolower($ToursType) == $selectedTourType ? 'selected' : '' }} >{{ $ToursType }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback nopadding" >
												@if (isset($ActivityResult->Private->Cars) && bool_array($ActivityResult->Private->Cars))
													<select name="" id="privateCar_{{ $fgfActivityUniqueCode }}" 
														class="form-control has-feedback p-left-10 privateCar" 
														data-Index="{{ $fgfActivityUniqueCode }}" 
														style="{{ $fgfTourType == 'private' ? '' : (isset($ActivityResult->Sic) ? 'display: none' : '') }}">
														@foreach ($ActivityResult->Private->Cars as $privateCar_key => $privateCar)
															<option value="{{ requireCar($activitiesSlice->noOfPax)*$privateCar->Price }}" 
																data-carCode="{{ ifset($privateCar->ID) }}" 
																data-carIndex="{{ $privateCar_key }}" 
																data-carCount="{{ requireCar($activitiesSlice->noOfPax) }}"
																{{ ifset($activitiesSlice->selectedActivities->$activityCode->privateCar->code) == $privateCar->ID ? 'selected' : '' }}
																>{{ requireCar($activitiesSlice->noOfPax) > 1 ? requireCar($activitiesSlice->noOfPax).' x ' : '' }}{{ $privateCar->CarName }} - {{ $privateCar->SeatingCapacity.'Seater' }}</option>
														@endforeach
													</select>
												@else
													<div class="m-top-10" id="privateCar_{{ $fgfActivityUniqueCode }}" style="{{ isset($ActivityResult->Sic) ? 'display: none;' : '' }}">There is no <b><i>Car</i></b> for this activity or <b>Check Manually</b></div>
												@endif
											</div>
										</div>
										{{-- /Date --}}
									</div>
									{{-- /if sic and private exist --}}
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<div class="height-150px vertical-parent">
								<div class="vertical-child">
									<h2><span class="currency">{{ $ActivityResult->Currency }}</span> 
										<span id="activityPrice_{{ $fgfActivityUniqueCode }}" class="activityPrice">{{ is_sic($activitiesSlice->noOfPax, $ActivityResult) }}</span>
									</h2> 
									<div class="m-top-30">
										<button
										class="btn {{ $isSetActivity ? 'btn-danger' : 'btn-primary' }} btn-block btn-activitySelect" 
											data-Index="{{ $fgfActivityUniqueCode }}"
											data-uniqueid="{{ $fgfActivityUniqueCode }}" 
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