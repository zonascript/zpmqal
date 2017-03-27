<script>
	function postFgfAgodaRoom(did, rid, hid) {
		var elem_id = "hotel_"+rid;
		var ids = {
				'did' : did,
				'hid' : hid,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/rooms/') }}/"+did,
			data: ids,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				var html = '';
				var rooms = responce.rooms;
				var uniqueKey = hid+'_fgfa';
				
				invokeMap(uniqueKey);

				if (rooms.length) {
					$('#loging_log').hide();

					$.each(rooms, function(i,v){
						html = makeFgfAgodaRoomHtml(i, v, ids);
						$('#'+uniqueKey+'_rooms').append(html);
					});

					$.each(responce.images, function(i,v){
						html = makeGallaryHtml(i, v);
						$('#'+uniqueKey+'_gimg').append(html);
					});

					$('#main_hotelDetail_'+uniqueKey).find('input').iCheck({
						checkboxClass: 'icheckbox_flat-green'
					});
				}
				else{
					return postFgfAgodaRoom(did, rid, hid);
				}
				
				postFgfAgodaDetail(ids);

			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					return postFgfAgodaRoom(did, rid, hid);
				}
			}
		});
	}
</script>


<script>
	function makeFgfAgodaRoomHtml(i, obj, ids) {
		var uniqueKey = obj.hotel_id+'_fgfa';
		var roomId = obj.id;
		var roomType = obj.roomtype
		var roomImage = obj.image;

		<?php 
			$html = view('b2b.protected.dashboard.pages.hotels.partials.fgf_agoda_partials.rooms')
							->render(); 
			$html = trimHtml($html);
		?>
		return '{!! $html !!}';
	}
</script>

<script>
	function makeGallaryHtml(i, obj) {
		return '<div class="height-160px width-48-p"><img class="width-100-p height-100p" src="'+obj.LocationWithSquareSize2X+'" /></div>'
	}
</script>

<script>
	function invokeMap(uniqueKey) {
		var map_iframe_src = $('#'+uniqueKey+'_map').attr('data-src');
		var map_iframe = '<div class="m-top-5"><iframe width="100%" height="360" src="'+map_iframe_src+'" ></iframe></div>';
		$('#'+uniqueKey+'_map').html(map_iframe);
	}
</script>

<script>
	function postFgfAgodaDetail(ids){
		var uniqueKey = ids.hid+'_fgfa';
		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/detail/') }}/"+ids.did,
			data: ids,
			success : function(responce){
				$('#'+uniqueKey+'_about').html(responce);
			}
		});
	}
</script>