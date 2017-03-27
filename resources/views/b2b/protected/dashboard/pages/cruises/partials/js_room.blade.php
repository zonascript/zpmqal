<script>
	$(document).on('ifChanged', 'input', function() {
		var type = $(this).attr('data-type');
		var isChecked = $(this).is(':checked');
		var parent = $(this).closest('.pick-drop-container');
		console.log(parent);
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
	});
</script>

{{-- Choose Room --}}
<script>
	$(document).on('click','.btn-chooseRoom', function(){
		var did = $(this).attr('data-did');
		var elemid = $(this).attr('data-elemid');
		var id = $(this).attr('data-index');
		var vendor = $(this).attr('data-vendor');
		var uniqueKey = $(this).attr('data-uid');

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

		var visibleHotelDetailId = $('.classCruiseDetail:visible').attr('id');
		var currntHotelDetailId = 'hoteldetail-'+uniqueKey;
		var currntHotelDetailBoxId = 'main_hotelDetail_'+uniqueKey;

		var isVisible = $('#'+currntHotelDetailId).is(':visible');

		if(isVisible){
			$('#'+currntHotelDetailId).hide();
		}
		else if(visibleHotelDetailId == undefined || visibleHotelDetailId != currntHotelDetailId){
			
			$('#'+currntHotelDetailId).show();
			$('#'+visibleHotelDetailId).hide();
			$('#'+currntHotelDetailBoxId).empty();

			// console.log(visibleHotelDetailId+' '+currntHotelDetailId);

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/builder/cruise/room/') }}/"+did,
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
		else{
			alert('Error!!!');
		}

	})
</script>
{{-- /Choose Room --}}



{{-- Book hotel --}}
<script>
	$(document).on('click', '.btn-bookRoom', function(){
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

		var data = {
			"_token" : csrf_token,
			"tk" : tk,
			"rk" : rk,
			"apk" : apk,
			"rok" : rok,
			"vdr" : vdr,
			"did" : did,
			"pu" : pickUpVal, {{-- pick_up --}}
			"pus" : pickUpSelect, {{-- pick_up_selected --}}
			"do" : dropOffVal, {{-- drop_off --}}
			"dos" : dropOffSelect, {{-- drop_off_selected --}}
			"next_rid" : next_rid,
		}


		postAddtoCartHotel(data);

		if (next_rid != "NaN") {
			// setTimeout(function () {   
			// 	tbtq(next_did, next_rid);
		 //  }, 3000)
		}else{
			setTimeout(function () {    
				document.location.href = "{{url('dashboard/package/builder/activities/'.$package->id)}}";
		  }, 10000)
		}
	});
</script>
{{-- /Book hotel --}}



<script>

	function postAddtoCartHotel(data) {
		/*Object must be like this 
		var data = {
			"_token" : "{{ csrf_token() }}",
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