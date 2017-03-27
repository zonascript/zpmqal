@if (isset($hotelRoom->detail->HotelInfoResult->HotelDetails->Images) && is_array($hotelRoom->detail->HotelInfoResult->HotelDetails->Images))
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_content" >
			<div class="gallery cf">
				@foreach ($hotelRoom->detail->HotelInfoResult->HotelDetails->Images as $roomImage)
					<div class="height-160px width-48-p">
						<img class="width-100-p height-100p" src="{{ $roomImage }}" />
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@else
	<p>Not Found</p>
@endif
