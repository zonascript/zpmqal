
<?php 
	$addActiviyHtml = view($viewPath.'.partials._add')->render();
	$addActiviyHtml = trimHtml($addActiviyHtml);
?>

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
			postSearchHotel();
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
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		var count = $(this).attr('data-count');
		var code = rid+'_'+count;
		count = parseInt(count)+1;
		$(this).attr('data-count', count);
		var elemid = 'rid_'+rid;
		var html = '{!! $addActiviyHtml !!}';
		$('#'+elemid).append(html);
		addDropzone('#uploadform_'+code);
		initDatePicker(rid);
	});

	{{-- /add-own-activity --}}


	{{-- remove-own --}}
	/*--Asking premission for delete--*/
	$(document).on('click', '.btn-remove-own', function() {
		uid = $(this).attr('data-uid');
		$('#btn_confirmed_activity').attr('data-uid', uid);
	});

	/*--Removed after confirmed--*/
	$(document).on('click', '#btn_confirmed_activity', function () {
		uid = $(this).attr('data-uid');
		$('#own_activity_'+uid).remove();
	});
	{{-- /remove-own --}}

	{{-- description pop up--}}
	$(document).on('click', '.btn-description', function () {
		showDescription(this); 
	});
	{{-- /description pop up--}}
</script>
@include($viewPath.'.partials.scripts.function')

