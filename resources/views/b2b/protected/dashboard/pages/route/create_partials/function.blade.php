
<script>
	function initTimePicker(elem, option = {}){
		var option = $.extend({}, {twentyFour: true}, option);
		$(elem).wickedpicker(option);

		/*$(parent).find('.datetimepicker').timepicker();*/

		/*$(parent).find('.datetimepicker').datetimepicker({
			formatDate:'d/m/Y',
			formatTime:'H:i',
			minDate: 0,
		});*/
	}
</script>

<script>
	function initDateTime(elem) {
		$(elem).datetimepicker({
			formatDate:'d/m/Y',
			formatTime:'H:i',
			minDate: 0,
		});
	}
</script>

<script>
	function addDestCount() {
		var totalDest = $('#btn-addDestination').attr('data-count');
		var totalDest = parseInt(totalDest);
		var totalDest = totalDest+1;
		$('#btn-addDestination').attr('data-count', totalDest);
		return totalDest;
	}
</script>

<script>
	function postRemoveRoute(rid) {
		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/route/'.$package->id.'/d') }}",
			data: {"_token" : csrf_token}
		});
	}
</script>

<script>
	function checkStartDate() {
		var startDate = $('#startDate').val();

		if(startDate != ''){
			$('#startDate').addClass('border-blue-2px');
			$('#startDate').removeClass('border-red');
			return true;
		}
		else{
			$('#startDate').addClass('border-red');
			$('#startDate').removeClass('border-blue-2px');
			alert('Please select start date...');
			/*setTimeout(function () {  */  
				$('#startDate').click();
		  /*}, 500);*/
			return false;
		}
	}
</script>

<script>
	function checkMode() {
		var mode = $('.destinationList').find('.mode.inctv');
		if (mode.length) {
			$(mode).addClass('border-red');
			myAlert('I think you forgot to select mode. it\'s vary easy just click on mode and select.');
			return false;
		}
		else{
			return true;
		}
	}
</script>

<script>
	function checkLocation() {
		var location = $('.destinationList').find('.location.inctv');
		if (location.length) {
			$(location).addClass('border-red');
			myAlert('You forgot to write location.');
			return false;
		}
		else{
			return true;
		}
	}
</script>

<script>
	function checkNights() {
		var nights = $('.destinationList').find('.nights.inctv');
		if (nights.length) {
			$(nights).addClass('border-red');
			myAlert('You forgot to select nights.');
			return false;
		}
		else{
			return true;
		}
	}
</script>

<script>
	function checkInputs() {
		if (checkStartDate() && checkMode() && checkLocation() && checkNights()) {
			return true;
		}
		else{
			return false;
		}
	}
</script>

<script>
	function changeInRoute(route) {
		$(route).addClass('no-rid');
	}
</script>

<script>
	function getRoute() {
		var route = []; 
		var routeCount = $('.destinationList').length;

		$('.destinationList').each(function(){
			var mode = $(this).find('.mode').val();
			if (mode == '') {
				$(this).find('.mode').addClass('border-red');
				myAlert('I think you forgot to select mode. it\'s vary easy just click on mode and select.');
				return false;
			}else{
				$(this).find('.mode').removeClass('border-red');
			}

			var origin = $(this).find('.origin').val();
			if (origin == '' && mode == 'flight') {
				$(this).find('.origin').addClass('border-red');
				myAlert('You forgot to write origin.');
				return false;
			}
			if((mode == 'flight' || mode == 'train' || mode == 'ferry') && origin.indexOf(', ') == -1){
				$(this).find('.origin').addClass('border-red');
				myAlert('You forgot to write origin.');
				return false;
			}
			else{
				$(this).find('.origin').removeClass('border-red');
			}

			var destination = $(this).find('.destination').val();
			if (destination == '') {
				$(this).find('.destination').addClass('border-red');
				myAlert('You forgot to write destination.');
				return false;
			}if(destination.indexOf(', ')  == -1){
				$(this).find('.destination').addClass('border-red');
				myAlert('You forgot to write destination.');
				return false;
			}else{
				$(this).find('.destination').removeClass('border-red');
			}

			var nights = $(this).find('.nights').val();
			if (nights == '') {
				$(this).find('.nights').addClass('border-red');
				myAlert('You forgot to select nights.');
				return false;
			}else{
				$(this).find('.nights').removeClass('border-red');
			}

			var origin_time = $(this).find('.origin-time').val();
			var destination_time = $(this).find('.destination-time').val();

			var routeData = {
				"mode" : mode,
				"origin" : origin,
				"origin_time" : origin_time,
				"destination" : destination,
				"destination_time" : destination_time,
				"nights" : nights,
			};

			route.push(routeData);
		});
		if (route.length == routeCount) {
			return route;
		}else{
			return false;
		}
	
	}
</script>

<script>
	function postRoute() {
		if (checkInputs()) {
			$('.destinationList.no-rid').each(function(){
				var thisElem = $(this);
				var rid = $(this).attr("data-rid");
				var mode = $(this).find('.mode').val();
				var origin = $(this).find('.origin').val();
				var nights = $(this).find('.nights').val();
				var destination = $(this).find('.destination').val();
				var origin_time = $(this).find('.origin-time').val();
				var destination_time = $(this).find('.destination-time').val();
				var pid = $('#startDate').attr('data-pid');

				var data = {
					"rid" : rid,
					"mode" : mode,
					"origin" : origin,
					"nights" : nights,
					"_token" : csrf_token,
					"origin_time" : origin_time,
					"destination" : destination,
					"destination_time" : destination_time
				};

				$.ajax({
					type:"post",
					url: "{{ url('dashboard/package/route/'.$package->id.'/r') }}",
					data: data,
					success : function (rid) {
						$(thisElem).attr('data-rid', rid);
					}
				});

				$(this).removeClass('no-rid');
				return true;
			});
			return true;
		}
		else{
			return false;
		}
	}
</script>

<script>
	function formSubmit(thisObj) {
		if(postRoute()){
			showWaitingLogo();
			var startDate = $('#startDate').val();
			var pid = $('#startDate').attr('data-pid');

			var roomGuests = $('.room-guest:visible').map(function() {

				var childAge = $(this).find('.age-elem').map(function() {
					return $(thisObj).val();
				}).get();

				return {
					'NoOfAdults': $(this).find('.adults').val(),
					'ChildAge': JSON.stringify(childAge),
				}
			}).get();

			$(thisObj).addClass('disabled');
			$(thisObj).prop('disabled', true);
			var req = $('#show_req').text();
			var data = {
				"_token" : csrf_token,
				"pid" : pid,
				"req" : req,
				"startDate" : startDate,
				"roomGuests" : roomGuests
			}

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/route/'.$package->id.'/u') }}",
				data: data,
				success: function(responce, textStatus, xhr) {
					if(xhr.status == 200){
						responce_obj = JSON.parse(responce);
						document.location.href = responce_obj.nextUrl;
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
				}
			});
		}
	}
</script>