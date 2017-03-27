

<script>
	function postFgfCruise(did, rid) {
		var elem_id = "cruise_"+rid;
		var ids = {
				"_token" : csrf_token,
				'did' : did,
				'rid' : rid,
				'elem_id' : elem_id
			};

		$.ajax({
			type:"post",
			url: "{{ url('/f/cruises/result/') }}/"+did,
			data: ids,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				// console.log(responce);
				var html = '';
				var cruises = responce.cruises;
				// console.log(cruises.length);
				if (cruises.length) {
					$('#loging_log').hide();

					$.each(cruises, function(i,v){
						html = makeFgfHtml(i, v, ids);
						$('#'+elem_id).append(html);
					});
					filter.initFilter(rid);
				}
				else{
					return postFgfCruise(did, rid);
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					/*postFgfCruise(did, rid);*/
				}
			}
		});
	}
</script>


<script>
	function makeFgfHtml(i, obj, ids) {
		var uniqueKey = obj.cruiseCode;
		var cruiseName = obj.cruiseName;
		var cruiseAddress = obj.address; 
		var sortcruiseAddress = cruiseAddress.substring(0, 40);
		var cruiseDescription = obj.description;
		var sortcruiseDescription = cruiseDescription.substring(0, 120);
		var starRating = obj.star_rating;
		var starRatingHtml = star_Rating(starRating);
		var cruiseImage = obj.images[0];

		<?php 
			$html = view('b2b.protected.dashboard.pages.cruises.partials.fgf_html')->render();
			$html = trimHtml($html);
		?>
		return '{!! $html !!}';
	}
</script>