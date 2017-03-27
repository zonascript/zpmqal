{{-- Hotel Description --}}
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Hotel Description</h2>
			<ul class="nav navbar-right panel_toolbox panel_toolbox1">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content" >
			<div>
				{!! pdfHotelDesc($hotelRoom->hotels[0]->description) !!}
			</div>
		</div>
	</div>
</div>
{{-- /Hotel Description --}}



{{-- Hotel Contacts --}}
<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Contact Details</h2>
			<ul class="nav navbar-right panel_toolbox panel_toolbox1">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<table class="table">
				<tbody>
					<tr>
						<td><b>Address:</b></td>
						<td>
							{{ $hotelRoom->hotels[0]->address }}
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</div>
{{-- /Hotel Contacts --}}


{{-- Hotel Facilities --}}
@if (is_array($hotelRoom->hotels[0]->amenities) && is_array($hotelRoom->amenities))
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Hotel Amenities</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox1">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content max-height-350px pre-scrollable scroll-bar" >
				<ul class="list-unstyled top_profiles scroll-view">
					@foreach ($hotelRoom->hotels[0]->amenities as $hotelAmenities)
						<li class="media event">
							<div class="media-body">
								<p>{{ $hotelRoom->amenities[$hotelAmenities]->name }}</p>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endif
{{-- /Hotel Facilities --}}