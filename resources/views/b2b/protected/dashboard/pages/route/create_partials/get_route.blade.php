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