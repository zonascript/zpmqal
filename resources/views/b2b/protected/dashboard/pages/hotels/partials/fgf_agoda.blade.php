<script>
	function postFgfAgoda(did, rid, index = 0) {
		var elem_id = "hotel_"+rid;
		var ids = {
				'did' : did,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('/a/hotels/result/') }}/"+did+"/"+index,
			data: ids,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				var html = '';
				var hotels = responce.hotels;
				$('#loging_log').hide();

				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeFgfAgodaHtml(i, v, ids);
						$('#'+elem_id).append(html);
					});

					/*filter.initFilter(rid);
					index = index+1;
					postFgfAgoda(did, rid, index)*/
				}
				/*else{
					return postFgfAgoda(did, rid, index);
				}*/
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					postFgfAgoda(did, rid);
				}
			}
		});
	}
</script>

<script>
		function postSearchFgfA(name, did, rid) {
		var elem_id = "hotel_"+rid;
		var ids = {
				'did' : did,
				'rid' : rid,
				'name' : name,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/hotel/find/a') }}/"+did,
			data: ids,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				var html = '';
				var hotels = responce.hotels;
				$('#loging_log').hide();

				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeFgfAgodaHtml(i, v, ids);
						html = html.replace('glowing-border', 'glowing-border border-green-2px');
						$('#'+elem_id).find('.border-green-2px').removeClass('border-green-2px');
						$('#'+elem_id).prepend(html);
					});
				}
			}
		});
	}
</script>

<script>
	function makeFgfAgodaHtml(i, obj, ids) {
		var hotel_id = obj.hotel_id;
		var uniqueKey = obj.hotel_id+'_fgfa';
		$('#li_'+obj.hotel_id+'_fgfa').remove();
		var hotelName = obj.hotel_name;
		var hotelAddress = obj.address; 
		hotelAddress = hotelAddress.replace(/, , /g, ', ');
		var sortHotelAddress = hotelAddress.substring(0, 40);
		var hotelDescription = obj.overview;
		var sortHotelDescription = hotelDescription.substring(0, 120);
		var starRating = obj.star_rating;
		var starRatingHtml = star_Rating(starRating);
		var hotelImage = obj.photo1;
		var latitude = obj.latitude;
		var longitude = obj.longitude;

		<?php 
			$html = view('b2b.protected.dashboard.pages.hotels.partials.fgf_agoda_partials.container')
							->render(); 
			$html = trimHtml($html);
		?>
		return '{!! $html !!}';
	}
</script>