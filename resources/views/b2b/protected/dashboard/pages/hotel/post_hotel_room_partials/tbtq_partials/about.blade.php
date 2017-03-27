@if (isset($hotelRoom->detail->HotelInfoResult) && $hotelRoom->detail->HotelInfoResult->ResponseStatus == 1)
	
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
					{!! pdfHotelDesc($hotelRoom->detail->HotelInfoResult->HotelDetails->Description) !!}
				</div>
			</div>
		</div>
	</div>
	{{-- /Hotel Description --}}


	{{-- Hotel Policy --}}
	@if ($hotelRoom->detail->HotelInfoResult->HotelDetails->HotelPolicy != '')
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Hotel Policy</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content" >
					<div>
						{{ $hotelRoom->detail->HotelInfoResult->HotelDetails->HotelPolicy }}
					</div>
				</div>
			</div>
		</div>
	@endif
	{{-- /Hotel Policy --}}


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
							<td class="width-100"><b>Contact No.:</b></td>
							<td>
								{{ $hotelRoom->detail->HotelInfoResult->HotelDetails->HotelContactNo }}
							</td>
						</tr>
						<tr>
							<td><b>Fax No.:</b></td>
							<td>
								{{ $hotelRoom->detail->HotelInfoResult->HotelDetails->FaxNumber }}
							</td>
						</tr>
						<tr>
							<td><b>Email:</b></td>
							<td>
								{{ $hotelRoom->detail->HotelInfoResult->HotelDetails->Email }}
							</td>
						</tr>
						<tr>
							<td><b>Address:</b></td>
							<td>
								{{ $hotelRoom->detail->HotelInfoResult->HotelDetails->Address }}
							</td>
						</tr>

					</tbody>
				</table>

			</div>
		</div>
	</div>
	{{-- /Hotel Contacts --}}


	{{-- Hotel Attractions --}}
	@if (is_array($hotelRoom->detail->HotelInfoResult->HotelDetails->Attractions) && !empty($hotelRoom->detail->HotelInfoResult->HotelDetails->Attractions))
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Attractions</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content scroll-bar" >
					<ul class="list-unstyled top_profiles max-height-350px scroll-view">
						@foreach ($hotelRoom->detail->HotelInfoResult->HotelDetails->Attractions as $attractions)
							@if (isset($attractions->Value))
								<li class="media event">
									<div class="media-body">
										<p>{{ $attractions->Value }}</p>
									</div>
								</li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	@endif
	{{-- /Hotel Attractions --}}


	{{-- Hotel Facilities --}}
	@if (is_array($hotelRoom->detail->HotelInfoResult->HotelDetails->HotelFacilities) && !empty($hotelRoom->detail->HotelInfoResult->HotelDetails->HotelFacilities))
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Hotel Facilities</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content max-height-350px pre-scrollable scroll-bar" >
					<ul class="list-unstyled top_profiles scroll-view">
						@foreach ($hotelRoom->detail->HotelInfoResult->HotelDetails->HotelFacilities as $hotelFacility)
							<li class="media event">
								<div class="media-body">
									<p>{{ $hotelFacility }}</p>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	@endif
	{{-- /Hotel Facilities --}}

@else
	<p>No details found</p>
@endif
{{-- /Hotel Rooms --}}