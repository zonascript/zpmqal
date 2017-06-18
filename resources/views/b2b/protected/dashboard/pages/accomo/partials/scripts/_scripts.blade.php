@include($viewDir.'.partials.scripts.objects')
<script>
	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		/*$('#loging_log').hide();*/
		@foreach ($package->accomoRoutes as $hotelRouteKey => $hotelRoute)
			postAccomo({{$hotelRoute->id}});
		@endforeach
	});
	{{-- /bootstrap-daterangepicker --}}

	{{-- autocomplete --}}
	$(document).on('keypress paste', '#filter_search', function(e) {
		var key = e.which;
		if(key == 13){ /*the enter key code*/
			postSearchProp();
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				showSpinIcon();
				var ridObj = getRidObject(idObject.crid);
				url = '{{ urlAccomoApi("search/name") }}/'+idObject.crid+'?format=json&_token='+csrf_token;
				$(this).autocomplete({ source: url });
			}
		}
	});


	$(document).on('autocompleteselect', '#filter_search', function (e, ui) {
		postSearchProp();
	});
	{{-- /autocomplete --}}

	{{-- search hotel --}}
	$(document).on('click', '#btn_filter_search', function() {
		postSearchProp();
	});
	{{-- /search hotel --}}

	{{-- check box chenge --}}
	$(document).on('ifChanged', 'input', function() {
		checkChange(this);
	});
	{{-- /check box chenge --}}

	{{-- Choose Room --}}
	$(document).on('click','.btn-chooseProp', function(){
		chooseProp(this);
	});
	{{-- /Choose Room --}}

	{{-- Book hotel --}}
	$(document).on('click', '.btn-bookProp', function(){
		bookProp(this);
	});
	{{-- /Book hotel --}}

	{{-- Model PopUp --}}
	$(document).on('click', ".btn-link.description", function(){
		showDescription(this);
	});
	{{-- /model PopUp --}}

	{{-- click on tab menu button --}}
	$(document).on('click', '.a_tab_menu',function () {
		setCrid($(this).attr('data-rid'));
	});
	{{-- click on tab menu button --}}

	{{-- next button --}}
	$(document).on('click', '#btn_next', function () {
		nextAccomoEvent(this);		
	});
	{{-- /next button --}}

	$(document).on('change', '.transfer', function () {
		if ($(this).hasClass('h-pick-up')) {
			params = {
						'is_pick_up' : 1,
						'pick_up' : $(this).val(),
					};
			addAttributes(params);
		}
		else if ($(this).hasClass('h-drop-off')) {
			params = {
						'is_drop_off' : 1,
						'drop_off' : $(this).val(),
					};
			addAttributes(params);
		}
	});
</script>

@include($viewDir.'.partials.scripts.function')
