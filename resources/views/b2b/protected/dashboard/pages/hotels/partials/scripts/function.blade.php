
<?php 
	$hotelHtml = view('b2b.protected.dashboard.pages.hotels.partials.html_partials.container')->render();
	$hotelHtml = trimHtml($hotelHtml);

	$hotelRoomHtml = view('b2b.protected.dashboard.pages.hotels.partials.html_partials.rooms')->render(); 
	$hotelRoomHtml = trimHtml($hotelRoomHtml);
?>

{{-- get rid object --}}
<script>
	function getRidObject(rid) {
		return idObject['hotel_'+rid];
	}
</script>
{{-- get rid object --}}


<script>
		function showSpinIcon() {
			$('#fa_home_filter_icon').addClass('hide');
			$('#fa_spin_filter_icon').removeClass('hide');
		}

		function hideSpinIcon() {
			$('#fa_spin_filter_icon').addClass('hide');
			$('#fa_home_filter_icon').removeClass('hide');
		}
</script>

{{-- show description --}}
<script>
	function showDescription(thisObj) {
		var popupTitle = proper($(thisObj).attr('data-title'));
		var popupBodyId = $(thisObj).attr('data-bodyid');
		var popupBody = $('#'+popupBodyId).html();
		$.alert({
			backgroundDismiss: true,
			keyboardEnabled: true,
			title: popupTitle,
			content: popupBody,
			columnClass: 'col-md-6 col-md-offset-3'
		});
	}
</script>
{{-- show description --}}

{{-- checkChange --}}
<script>
	function checkChange(thisObj) {
		var type = $(thisObj).attr('data-type');
		var isChecked = $(thisObj).is(':checked');
		var parent = $(thisObj).closest('.pick-drop-container');
		/*console.log(parent);*/
		if (type == 'pick_up') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 0);
			}
		}
		else if (type == 'drop_off') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 0);
			}
		}
		else if(type == 'meal'){
			if (isChecked) {
				$(thisObj).addClass('selected');
			}
			else{
				$(thisObj).removeClass('selected')
			}
		}
	}
</script>
{{-- /check Change --}}


{{-- post hotel --}}
<script>
	function postHotels(rid) {
		var ridObj 	= getRidObject(rid);
		var did 		= ridObj.did;
		var elem_id = ridObj.elem_id;

		$.ajax({
			type:"post",
			url: "{{ url('fatch/hotels/result') }}/"+did,
			data: { '_token' : csrf_token },
			success: function(response, textStatus, xhr) {
				var html = '';
				var response = JSON.parse(response);
				var hotels = response.hotels;

				$('#loging_log').hide();
				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeHotelObject(i, v, rid);
						$('#'+elem_id).append(html);
					});
				}
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
{{-- post hotel --}}



{{-- make hotel object --}}
<script>
	function makeHotelObject(i, object, rid) {
		var code = object.id;
		var ukey = code+'_'+object.vendor; {{-- uniqueKye = hotel_id_vendor --}}
		var name = proper(object.name);
		var address = object.address.replace(/, , /g, ', '); 
		var sortAddress = address.substring(0, 50);
		var sortDescription = object.description.substring(0, 120);
		var starRatingHtml = star_Rating(object.star_rating);
		var ridObj = getRidObject(rid);
		var hotel = {
				"ukey" : ukey,
				"name" : name,
				"code" : code,
				"ridObj" : ridObj,
				"address" : address,
				"vendor" : object.vendor,
				"image" : object.image,
				"latitude" : object.latitude,
				"longitude" : object.longitude,
				"sortAddress" : sortAddress,
				"starRating" : object.star_rating,
				"description" : object.description,
				"starRatingHtml" : starRatingHtml,
				"sortDescription" : sortDescription
			};

		var sameElem = $('#'+ridObj.elem_id).find('.li_'+ukey);

		if (sameElem.length) {
			moveToTop(sameElem);
			return false;
		}
		else{
			return makeHotelHtml(hotel);
		}
		// $('#'+ridObj.elem_id).find('.li_'+ukey).remove(); {{-- Removing old cart --}}
	}
</script>
{{-- make hotel object --}}


{{-- make hotel html --}}
<script>
	function makeHotelHtml(hotel) {
		var appendHtml = '';
		var searchWord = '';
		appendHtml += '{!!$hotelHtml!!}';
		return appendHtml;
	}
</script>
{{-- make hotel html --}}


{{-- Choose room --}}
<script>
	function chooseRoom(thisObj) {
		$('#loging_log').show();
		var hid = $(thisObj).attr('data-hid');
		var rid = $(thisObj).attr('data-rid');
		var ukey = $(thisObj).attr('data-uid');
		var is_add = $(thisObj).attr('data-isadd');
		var vendor = $(thisObj).attr('data-vendor');
		var parent = $(thisObj).closest('.main-list-item');
		var parentList = $(thisObj).closest('.list.list-unstyled');
		var ridObj = getRidObject(rid);
		var did = ridObj.did;

		if (is_add == 1) {
			$(thisObj).addClass('btn-primary')
									.removeClass('btn-danger')
										.attr('data-isadd', 0)
											.text('Rooms')

			$(parentList).find('.btn-chooseRoom.btn-dark')
										.addClass('btn-primary')
											.prop('disabled', false)
												.removeClass('btn-dark')

			$(parent).find('.hotel-detail').hide();

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/builder/hotel/remove/') }}/"+did,
				data: {"_token" : csrf_token},
				success : function (response) {
					$('#loging_log').hide();
				}
			});
		}
		else{
			$(thisObj).addClass('btn-danger')
									.removeClass('btn-primary')
										.attr('data-isadd', 1)
											.text('Selected');


			$(parentList).find('.btn-chooseRoom.btn-primary')
											.addClass('btn-dark')
												.prop('disabled', true)
													.removeClass('btn-primary')
			
			$(parent).find('.hotel-detail').show();
			var next_did = ridObj.next_did;
			var next_rid = ridObj.next_rid;

			var data = {
					"hid" : hid,
					"vdr" : vendor,
					"nrid" : next_rid,
					"_token" : csrf_token
				}

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/builder/hotel/room') }}/"+did,
				data: data,
				success: function(response, textStatus, xhr) {
					response = JSON.parse(response);
					response['rid'] = rid;
					response['hid'] = hid;
					response['vendor'] = vendor;
					populateInTab(response);
					$('#loging_log').hide();
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
					}
					$('#loging_log').hide();
				}
			});
		}
	}
</script>
{{-- /Choose room --}}



{{-- Book Room --}}
<script>
	function bookRoom(thisObj) {
		$('#loging_log').show();
		$('.btn-bookRoom.btn-danger').addClass('btn-primary')
																	.text('Add')
																		.removeClass('btn-danger');

		$(thisObj).addClass('btn-danger').text('Remove');

		var parentLi = $(thisObj).closest('.main-list-item');
		var chooseRoomElem = $(parentLi).find('.btn-chooseRoom');
		var rid = chooseRoomElem.data('rid');
		var hid = chooseRoomElem.data('hid');
		var vdr = chooseRoomElem.data('vendor');
		var ridObj = getRidObject(rid);
		var did = ridObj.did;
		var elem_id = ridObj.elem_id;
		var next_rid = ridObj.next_rid;
		var roomContainer = $(thisObj).closest('.room-container');
		var pickUpVal = $(roomContainer).find('.h-pick-up').val();
		var dropOffVal = $(roomContainer).find('.h-drop-off').val();
		var pickUpSelect = $(roomContainer).find('.h-pick-up').data('selected');
		var dropOffSelect = $(roomContainer).find('.h-drop-off').data('selected');
		var lunch = $(roomContainer).find('.meal.lunch.selected').data('meal');
		var dinner = $(roomContainer).find('.meal.dinner.selected').data('meal');
		var breakfast = $(roomContainer).find('.meal.breakfast.selected').data('meal');

		var tk = '';
		var rk = '';
		var apk = '';
		var rok = '';

		if (vdr == 'ss') {
			apk = $(thisObj).attr('data-apk');
			rok = $(thisObj).attr('data-rok');
			rk = $(thisObj).attr('data-rk');
		}
		else if(vdr == 'tbtq'){
			tk = $(thisObj).attr('data-tk');
		}
		else if(vdr == 'a' || vdr == 'b')
		{
			rmid = $(thisObj).data('rmid');
		}

		var data = {
			"tk" : tk,
			"rk" : rk,
			"apk" : apk,
			"rok" : rok,
			"vdr" : vdr,
			"did" : did,
			"hid" : hid,
			"rmid" : rmid,
			"pu" : pickUpVal, {{-- pick_up --}}
			"pus" : pickUpSelect, {{-- pick_up_selected --}}
			"do" : dropOffVal, {{-- drop_off --}}
			"dos" : dropOffSelect, {{-- drop_off_selected --}}
			"next_rid" : next_rid,
			"breakfast" : breakfast,
			"lunch" : lunch,
			"dinner" : dinner,
			"_token" : csrf_token
		}

		postAddtoCartHotel(data);
		moveToTop(parentLi);
		$('#loging_log').hide();

		if (next_rid == "NaN") {
			setTimeout(function () {    
				document.location.href = "{{url('dashboard/package/builder/event/'.$package->id.'/hotel')}}";
			}, 5000);
		}
		/*else{
			setTimeout(function () {   
				tbtq(next_did, next_rid);
			}, 3000);
		}*/
	}
</script>
{{-- /Book Room --}}


{{-- move to top --}}
<script>
	function moveToTop(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).prepend(thisObj)
							.find('.border-green-2px')
								.removeClass('border-green-2px');

		$(thisObj).find('.x_panel.glowing-border').addClass('border-green-2px');
	}
</script>
{{-- /move to top --}}


{{-- populate in tab --}}
<script>
	function populateInTab(obj) {
		var ukey = obj.hid+'_'+obj.vendor+'_'+obj.rid;

		$.each(obj.rooms,function(roomKey, room) {
			$('#'+ukey+'_rooms').append(makeRoomHtml(room));
			invokeIcheck('#'+ukey+'_rooms');
		});

		$.each(obj.images, function(imagekey, image) {
			$('#'+ukey+'_gallary').find('.gallery.cf').append(makeGallaryHtml(image));
		});

		invokeMap(ukey);
	}
</script>
{{-- /populate in tab --}}




{{-- make room html --}}
<script>
	function makeRoomHtml(obj) {
		var roomId = obj.id;
		var roomType = obj.roomtype
		var roomImage = obj.image;
		return '{!! $hotelRoomHtml !!}';
	}
</script>
{{-- /make room html --}}


{{-- make gallary html --}}
<script>
	function makeGallaryHtml(obj) {
		return '<div class="height-160px width-48-p"><img class="width-100-p height-100p" src="'+obj+'" /></div>'
	}
</script>
{{-- /make gallary html --}}


{{-- invoke map --}}
<script>
	function invokeMap(ukey) {
		var src = $('#'+ukey+'_map').attr('data-src');
		$('#'+ukey+'_map').html('<div class="m-top-5"><iframe width="100%" height="360" src="'+src+'" ></iframe></div>');
	}
</script>
{{-- /invoke map --}}


{{-- invoke Icheck --}}
<script>
	function invokeIcheck(elem) {
		$(elem).find('input').iCheck({
			checkboxClass: 'icheckbox_flat-green'
		});
	}
</script>
{{-- /invoke Icheck --}}


<script>
	function postSearchHotel() {
		hideSpinIcon();
		$('#loging_log').show();
		var name = $('#filter_search').val();
		var rid = $('#tab_menu').find('.active').attr('data-rid');
		var ridObj = getRidObject(rid);
		var elem_id = ridObj.elem_id;
		var did = ridObj.did;
		var data = {
				'name' : name,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/hotels/search/') }}/"+did+'?format=json',
			data: data,
			success: function(response, textStatus, xhr) {
				var html = '';
				var response = JSON.parse(response);
				var hotels = response.hotels;

				$('#loging_log').hide();
				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeHotelObject(i, v, rid);
						$('#'+elem_id).append(html);
					});
				}
			}
		});
	}
</script>


<script>
	function postFgfAgodaDetail(ids){
		var ukey = ids.hid+'_fgfa';
		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/detail/') }}/"+ids.did,
			data: ids,
			success : function(response){
				$('#'+ukey+'_about').html(response);
			}
		});
	}
</script>

{{-- add to cart --}}
<script>
	function postAddtoCartHotel(data) {

		/*Object must be like this 
		var data = {
			"_token" : csrf_token,
			"did" : did,
			"index" :id,
			"vendor" : vendor
		}*/

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/builder/hotel/room/book/') }}/"+data.did,
			data: data,
			success : function(response){
				response = JSON.parse(response);
				if (response.status == 200) {
					$('#a_hotel_'+data.next_rid).click();
					$(window).scrollTop(0);
				}else{
					alert('Something went wrong please try again.');
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				alert('Something went wrong please try again.');
			}
		});
	}
</script>
{{-- add to cart --}}