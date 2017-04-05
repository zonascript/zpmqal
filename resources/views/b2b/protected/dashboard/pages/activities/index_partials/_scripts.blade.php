
<?php 
	$addActiviyHtml = view('b2b.protected.dashboard.pages.activities.index_partials._add')->render();
	$addActiviyHtml = trimHtml($addActiviyHtml);
?>

@include('b2b.protected.dashboard.pages.activities.index_partials.js_objects')

{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
		 	@if ($hotelRouteKey)
				setTimeout(function () {   
					uniActivities({{$hotelRoute->id}});
			 	}, {{ 3000*($hotelRouteKey+1) }})
		 	@else
				uniActivities({{$hotelRoute->id}});
		 	@endif
		@endforeach

	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- autocomplete --}}
<script>
	$(document).on('keypress paste{{--keyup  keydown --}}', '#filter_search', function(e) {
		var name = $(this).val();
		if (name.length > 2) {
			var did = $('#tab_menu').find('.active').attr('data-did');
			url = '{{ url("dashboard/activities/search/") }}/'+did+'?format=json&_token='+csrf_token;
			$(this).autocomplete({ source: url });
		}
	});
</script>

<script>
	$(document).on('autocompleteselect', '#filter_search', function (e, ui) {
		$('#loging_log').show();
		var rid = $('#tab_menu').find('.active').attr('data-rid');
		postSearchActivity(rid);
	});
</script>
{{-- /autocomplete --}}

<script>
	$(document).on('click', '#btn_filter_search', function() {
		$('#loging_log').show();
		var rid = $('#tab_menu').find('.active').attr('data-rid');
		postSearchActivity(rid);
	});
</script>

{{-- filter List.js--}}
{{-- <script>
	var filter = {
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			'activities_{{ $hotelRoute->id }}' : '',
		@endforeach
		initFilter : function (targetList) {
			var options = {
				valueNames: ['search-word']
			};
			@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
				if (targetList == {{ $hotelRoute->id }}) {
					this.activities_{{ $hotelRoute->id }} = new List("activities_{{ $hotelRoute->id }}_div", options);
				}
			@endforeach
		}
	}
	
</script>

<script>
	$(document).on('keypress keyup keydown', "#filter_search", function(){
		var targetList = $('#tab_menu').find('.active').attr('data-list');
		var search = $(this).val();
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			if (targetList == "activities_{{ $hotelRoute->id }}_div") {
				filter.activities_{{ $hotelRoute->id }}.search(search);
			}
		@endforeach
	});

</script> --}}
{{-- /filter List.js --}}


{{-- Activity Select Button --}}
<script>
	$(document).on('click', '.btn-activitySelect', function(){
		$('#loging_log').show();
		selectActivity(this);
		$('#loging_log').hide();
	});
</script>
{{-- /Activity Select Button --}}


{{-- Save Activities --}}
<script>
	$(document).on('click', '#saveActivities', function(){
		/*var rid = $(this).attr('data-rid');
		var did = $(this).attr('data-did');
		if (rid == '') {*/
			rid = $('.li-menu-dest.active').attr('data-rid');
			did = $('.li-menu-dest.active').attr('data-did');
		/*}*/
		makeActivitiesJson(rid, did);
	});
</script>
{{-- /Save Activities --}}


{{-- add-own-activity --}}
<script>
	$(document).on('click', '.add-own-activity', function() {
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		var count = $(this).attr('data-count');
		var code = rid+'_'+count;
		count = parseInt(count)+1;
		$(this).attr('data-count', count);
		var elemid = 'activities_'+rid;
		var html = '{!! $addActiviyHtml !!}';
		$('#'+elemid).append(html);
		addDropzone('#uploadform_'+code);
		initDatePicker(rid);
	});
</script>
{{-- /add-own-activity --}}


{{-- Model PopUp --}}
<script>
	$(document).on('click', "[data-toggle='modal']", function(){
		var popupTarget = $(this).attr('data-target');
		var popupTitle = $(this).attr('data-title');
		var popupButton = $(this).attr('data-button');
		var popupBodyId = $(this).attr('data-bodyid');
		var popupBody = $('#'+popupBodyId).html();
		var popupSize = '';
		
		if(popupTarget == '.bs-example-modal-sm'){
			popupSize = '2';
		}

		$('#myModalLabel'+popupSize).html(popupTitle);
		$('#myModalBody'+popupSize).empty();
		$('#myModalBody'+popupSize).html(popupBody);
		
		if(popupButton == 'false'){
			$('#myModalButton'+popupSize).hide();
		}
	})
</script>
{{-- /model PopUp --}}


{{-- remove-own --}}
<script>
	/*--Asking premission for delete--*/
	$(document).on('click', '.btn-remove-own', function() {
		uid = $(this).attr('data-uid');
		$('#btn_confirmed_activity').attr('data-uid', uid);
	});

	/*--Removed after confirmed--*/
	$(document).on('click', '#btn_confirmed_activity', function () {
		uid = $(this).attr('data-uid');
		$('#own_activity_'+uid).remove();
	})
</script>
{{-- /remove-own --}}

@include('b2b.protected.dashboard.pages.activities.index_partials.js_function')

