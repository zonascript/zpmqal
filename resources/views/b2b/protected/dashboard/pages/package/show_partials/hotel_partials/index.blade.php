@if(!is_null($hotelRoute->hotel->detail))
<?php
	$hotelDetail = $hotelRoute->hotel->detail;
	$uniqueKey = $hotelDetail->vendor.'_'.$hotelDetail->code;
?>
<ul class="list list-unstyled">
	<li class="m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
					<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
						<img src="{{ $hotelDetail->image }}" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="nopadding hotelName">{{ $hotelDetail->name }}</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>{{ $hotelDetail->address }}</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							{!! $hotelDetail->starRatingHtml !!}
							<div hidden>
								<p class="starRating" >{{ $hotelDetail->starRating }}</p>
							</div>
							<span class="font-size-13">
								 | <b>Check In : </b>{{ $hotelDetail->startDate }}
								 | <b>Check Out : </b>{{ $hotelDetail->endDate }}
							</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 font-size-13 m-top-5">
							<b>RoomType : </b>{{ $hotelDetail->roomType }}
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							{{ $hotelDetail->shortDescription }}
							<button 
								class="btn-link cursor-pointer btn-model" 
								data-title="{{ $hotelDetail->name }} : Description" 
								data-bodyid="hotelDescription_{{ $uniqueKey}}">More
							</button>
							<div id="hotelDescription_{{ $uniqueKey }}" hidden>
								{!! $hotelDetail->htmlDescription !!}
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
