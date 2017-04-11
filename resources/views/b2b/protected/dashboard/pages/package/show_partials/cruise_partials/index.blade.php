@if(!is_null($cruiseRoute->cruise->detail))
<?php
	$cruiseDetail = $cruiseRoute->cruise->detail;
	$uniqueKey = $cruiseDetail->vendor.'_'.$cruiseDetail->code;
?>
<ul class="list list-unstyled">
	<li class="m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
					<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
						<img src="{{ $cruiseDetail->image }}" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="nopadding hotelName">{{ $cruiseDetail->name }}</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>{{ $cruiseDetail->address }}</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							{!! $cruiseDetail->starRatingHtml !!}
							<div hidden>
								<p class="starRating" >{{ $cruiseDetail->starRating }}</p>
							</div>
							<span class="font-size-13">
								 | <b>Check In : </b>{{ $cruiseDetail->startDate }}
								 | <b>Check Out : </b>{{ $cruiseDetail->endDate }}
							</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 font-size-13 m-top-5">
							<b>Cabin : </b>{{ $cruiseDetail->roomType }}
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							{{ $cruiseDetail->shortDescription }}
							<button 
								id="btn-amenitiesMore" 
								class="btn-link cursor-pointer btn-model" 
								data-toggle="modal" 
								data-target=".bs-example-modal-lg"
								data-title="{{ $cruiseDetail->name }} : Description" 
								data-bodyid="hotelDescription{{ $uniqueKey}}" 
								data-button="false">More
							</button>
							<div id="hotelDescription{{ $uniqueKey }}" hidden>
								{!! $cruiseDetail->htmlDescription !!}
							</div>
						</div>

					</h2>
				</div>
			</div>
		</div>
	</li>
</ul>
{{-- @else
	<u l><li class="min-height-110px"><h1>No Result Found</h1></li></ul>--}}
@endif
