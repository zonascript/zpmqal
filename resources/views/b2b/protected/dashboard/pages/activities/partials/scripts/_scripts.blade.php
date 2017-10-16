@include($viewPath.'.partials.scripts.objects')
<script>
	var windata = { is_fine : true };
	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		@foreach ($package->activityRoutes as $activityRouteKey => $activityRoute)
			postActivities({{$activityRoute->id}});
		@endforeach
	});
	{{-- /bootstrap-daterangepicker --}}



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
		setTimeout(function () {
			nextHotelEvent();
		}, 2000);
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

	$(document).on('click', '.btn-link.toggle-group', function () {
		toggleGroup(this);
	});
</script>
@include($viewPath.'.partials.scripts.autocomplete')
@include($viewPath.'.partials.scripts.function')

