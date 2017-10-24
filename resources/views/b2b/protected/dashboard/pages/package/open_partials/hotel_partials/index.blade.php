@if(!is_null($hotelRoute->hotelDetail()))
<?php
	$hotelDetail = $hotelRoute->hotelDetail();
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
							<h3 class="nopadding hotelName">{{ $hotelDetail->name }} {!! $hotelDetail->starRatingHtml !!}</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>{{ $hotelDetail->address }}</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<div hidden>
								<p class="starRating" >{{ $hotelDetail->starRating }}</p>
							</div>
							<ul class="pipe font-size-13 nopadding m-top-5">
								<li><b>Check In : </b>{{ $hotelDetail->startDate }}</li>
								<li><b>Check Out : </b>{{ $hotelDetail->endDate }}</li>
								<li><b>Breakfast : </b>{{ $hotelRoute->is_breakfast ? 'Yes' : 'No' }}</li>
								<li><b>Lunch : </b>{{ $hotelRoute->is_lunch ? 'Yes' : 'No' }}</li>
								<li><b>Dinner : </b>{{ $hotelRoute->is_dinner ? 'Yes' : 'No' }}</li>
							</ul>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 font-size-13 m-top-5">
							<b>RoomType : </b>{{ implode(',', $hotelDetail->roomType) }}
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							{{ $hotelDetail->shortDescription }}
							<button 
								class="btn-link cursor-pointer btn-model" 
								data-title="{{ $hotelDetail->name }} : Description" 
								data-bodyid="hotelDescription_{{ $hotelDetail->id }}">More
							</button>
							<div id="hotelDescription_{{ $hotelDetail->id }}" hidden>
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
