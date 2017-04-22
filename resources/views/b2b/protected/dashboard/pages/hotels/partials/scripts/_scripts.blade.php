@include('b2b.protected.dashboard.pages.hotels.partials.scripts.objects')

{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			postHotels({{$hotelRoute->id}});
			{{-- tbtq({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}});
			sshtl({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}}); --}}
		@endforeach

	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- autocomplete --}}
<script>
	$(document).on('keypress paste', '#filter_search', function(e) {
		var key = e.which;
		if(key == 13){ /*the enter key code*/
			postSearchHotel();
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				showSpinIcon();
				var did = $('#tab_menu').find('.active').attr('data-did');
				url = '{{ url("dashboard/hotels/search/name") }}/'+did+'?format=json&_token='+csrf_token;
				$(this).autocomplete({ source: url });
			}
		}
	});
</script>

<script>
	$(document).on('autocompleteselect', '#filter_search', function (e, ui) {
		postSearchHotel();
	});
</script>

{{-- /autocomplete --}}

{{-- search hotel --}}
<script>
	$(document).on('click', '#btn_filter_search', function() {
		postSearchHotel();
	});
</script>
{{-- /search hotel --}}

{{-- check box chenge --}}
<script>
	$(document).on('ifChanged', 'input', function() {
		checkChange(this);
	});
</script>
{{-- /check box chenge --}}

{{-- Choose Room --}}
<script>
	$(document).on('click','.btn-chooseRoom', function(){
		chooseRoom(this);
	})
</script>
{{-- /Choose Room --}}

{{-- Book hotel --}}
<script>
	$(document).on('click', '.btn-bookRoom', function(){
		bookRoom(this);
	});
</script>
{{-- /Book hotel --}}

{{-- Model PopUp --}}
<script>
	$(document).on('click', ".btn-link.description", function(){
		showDescription(this);
	})
</script>
{{-- /model PopUp --}}

@include('b2b.protected.dashboard.pages.hotels.partials.scripts.function')
