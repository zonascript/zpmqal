
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
			url: "{{ url('dashboard/package/route') }}/"+rid+"/d", 
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