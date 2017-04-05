<script>
	$(document).on('ifChanged', 'input', function() {
		var type = $(this).attr('data-type');
		var isChecked = $(this).is(':checked');
		var parent = $(this).closest('.pick-drop-container');
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
				$(this).addClass('selected');
			}
			else{
				$(this).removeClass('selected')
			}
		}

	});
</script>

{{-- Choose Room --}}
<script>
	$(document).on('click','.btn-chooseRoom', function(){
		var is_add = $(this).attr('data-isadd');
		var did = $(this).attr('data-did');
		var hid = $(this).attr('data-hid');
		var id = $(this).attr('data-hotelIndex');
		var elemid = $(this).attr('data-elemid');
		var vendor = $(this).attr('data-vendor');
		var uniqueKey = $(this).attr('data-uid');

		if (is_add == 1) {
			$(this).addClass('btn-primary');
			$(this).removeClass('btn-danger');
			$(this).attr('data-isadd', 0);
			$(this).text('Rooms');
			$('#'+elemid).find('.btn-chooseRoom.btn-dark').addClass('btn-primary');
			$('#'+elemid).find('.btn-chooseRoom.btn-dark').prop('disabled', false);
			$('#'+elemid).find('.btn-chooseRoom.btn-dark').removeClass('btn-dark');
			$('#hoteldetail-'+uniqueKey).hide();

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/builder/hotel/remove/') }}/"+did,
				data: {"_token" : csrf_token}
			});
		}
		else{
			$(this).addClass('btn-danger');
			$(this).removeClass('btn-primary');
			$(this).attr('data-isadd', 1);
			$(this).text('Delete');
			$('#'+elemid).find('.btn-chooseRoom.btn-primary').addClass('btn-dark');
			$('#'+elemid).find('.btn-chooseRoom.btn-primary').prop('disabled', true);
			$('#'+elemid).find('.btn-chooseRoom.btn-primary').removeClass('btn-primary');

			
			var rid = idObject[elemid].rid;
			var next_did = idObject[elemid].next_did;
			var next_rid = idObject[elemid].next_rid;

			var data = {
					"_token" : csrf_token,
					"did" : did,
					"index" :id,
					"next_rid" : next_rid,
					"vendor" : vendor
				}

			var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
			var currntHotelDetailId = 'hoteldetail-'+uniqueKey;
			var currntHotelRoomlId = 'roomresult-'+uniqueKey; // this is no longer used
			var currntHotelDetailBoxId = 'main_hotelDetail_'+uniqueKey;

			var isVisible = $('#'+currntHotelDetailId).is(':visible');

			if(isVisible){
				$('#'+currntHotelDetailId).hide();
			}
			else if(visibleHotelDetailId == undefined || visibleHotelDetailId != currntHotelDetailId){
				
				$('#'+currntHotelDetailId).show();
				$('#'+visibleHotelDetailId).hide();

				if (vendor == 'a') {
					postFgfAgodaRoom(did, rid, hid);
				}
				else{
					// console.log(visibleHotelDetailId+' '+currntHotelDetailId);

					$.ajax({
						type:"post",
						url: "{{ url('dashboard/package/builder/hotel/room/') }}/"+did,
						data: data,
						success: function(responce, textStatus, xhr) {
							// console.log(textStatus);
							if(xhr.status == 200){
								$('#'+currntHotelDetailBoxId).empty();
								$('#'+currntHotelDetailBoxId).html(responce);
								
								$('#'+currntHotelDetailBoxId).find('input').iCheck({
									checkboxClass: 'icheckbox_flat-green'
								});
							}
						},
						error: function(xhr, textStatus) {
							if(xhr.status == 401){
								window.open("{{ url('login') }}", '_blank');
							}
							else if(xhr.status == 500){
								var responceHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
								$('#'+currntHotelDetailBoxId).html(responceHtml);
							}
						},
					});

				}
			}
			else{
				alert('Error!!!');
			}
		}

		$('#loging_log').hide();
		

	})
</script>
{{-- /Choose Room --}}



{{-- Book hotel --}}
<script>
	$(document).on('click', '.btn-bookRoom', function(){
		$('#loging_log').show();

		$('.btn-bookRoom.btn-danger').addClass('btn-primary');
		$('.btn-bookRoom.btn-danger').text('Add');
		$('.btn-bookRoom.btn-danger').removeClass('btn-danger');

		$(this).addClass('btn-danger');
		$(this).text('Remove');
		
		var vdr = $(this).attr('data-vendor');
		var parent = $(this).closest('.main-roomContainer');
		var did = $('.li-menu-dest.active').attr('data-did');
		var rid = $('.li-menu-dest.active').attr('data-rid');
		var elem_id = "hotel_"+rid;
		var next_did = idObject[elem_id].next_did;
		var next_rid = idObject[elem_id].next_rid;
		var pickUpVal = $(parent).find('.h-pick-up').val();
		var dropOffVal = $(parent).find('.h-drop-off').val();
		var pickUpSelect = $(parent).find('.h-pick-up').attr('data-selected');
		var dropOffSelect = $(parent).find('.h-drop-off').attr('data-selected');
		var breakfast = $(parent).find('.meal.breakfast.selected').attr('data-meal');
		var lunch = $(parent).find('.meal.lunch.selected').attr('data-meal');
		var dinner = $(parent).find('.meal.dinner.selected').attr('data-meal');
		
		var tk = '';
		var rk = '';
		var apk = '';
		var rok = '';

		if (vdr == 'ss') {
			apk = $(this).attr('data-apk');
			rok = $(this).attr('data-rok');
			rk = $(this).attr('data-rk');
		}
		else if(vdr == 'tbtq'){
			tk = $(this).attr('data-tk');
		}
		else if(vdr == 'a')
		{
			hid = $(this).attr('data-hid');
			rmid = $(this).attr('data-rmid');
		}

		var data = {
			"_token" : csrf_token,
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
			"dinner" : dinner
		}

		postAddtoCartHotel(data);

		$(this).closest('.list.list-unstyled').prependTo("#"+elem_id);

		$('#loging_log').hide();

		if (next_rid == "NaN") {
			setTimeout(function () {    
				document.location.href = "{{url('dashboard/package/builder/activities/'.$package->id)}}";
		  }, 5000)
		}
		// else{
			// setTimeout(function () {   
			// 	tbtq(next_did, next_rid);
		 //  }, 3000)
		// }
	});
</script>
{{-- /Book hotel --}}



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
			success : function(responce){
				responce = JSON.parse(responce);
				if (responce.status == 200) {
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