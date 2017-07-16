@include($viewPath.'.partials.scripts.objects')
<script>
	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			postActivities({{$hotelRoute->id}});
		@endforeach
	});
	{{-- /bootstrap-daterangepicker --}}

	{{-- autocomplete --}}
	$(document).on('keypress paste	{{--keyup  keydown --}}', '#filter_search', function(e) {
		var key = e.which;
		if(key == 13){ /*the enter key code*/
			searchActivities();
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				showSpinIcon();
				var rid = idObject.crid;
				url = '{{ url("api/package/activities/names") }}/'+rid+'?format=json&_token='+csrf_token;
				$(this).autocomplete({ source: url });
			}
		}
	});



	$(document).on('autocompleteselect', '#filter_search', function (e, ui) {
		searchActivities();
	});
	{{-- /autocomplete --}}


	$(document).on('click', '#btn_filter_search', function() {
		searchActivities();
	});


	{{-- Activity Select Button --}}
	$(document).on('click', '.btn-activitySelect', function(){
		$('#loging_log').show();
		selectActivity(this);
		$('#loging_log').hide();
	});
	{{-- /Activity Select Button --}}


	{{-- Save Activities --}}
	$(document).on('click', '#saveActivities', function(){
		$.each(idObject.rid, function (i, v) {
			var firstLi = $('#rid_'+v).find('.activity-container');
			addActivity(firstLi[0]);
		});
		nextHotelEvent();
	});
	{{-- /Save Activities --}}

	$(document).on('click', '.a_tab_menu', function () {
		setCrid($(this).attr('data-rid'));
	});

	{{-- add-own-activity --}}
	$(document).on('click', '.add-own-activity', function() {
		addOwnActivity(this);
	});
	{{-- /add-own-activity --}}


	{{-- remove-own --}}
	/*--Asking premission for delete--*/
	$(document).on('click', '.btn-remove-own', function() {
		removeOwnActivity(this);
	});
	{{-- /remove-own --}}

	{{-- description pop up--}}
	$(document).on('click', '.btn-description', function () {
		showDescription(this); 
	});
	{{-- /description pop up--}}
</script>
@include($viewPath.'.partials.scripts.function')

