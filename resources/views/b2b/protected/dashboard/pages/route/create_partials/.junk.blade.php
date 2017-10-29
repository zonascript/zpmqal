<script>
	
	$(document).on('click', '#cancel_req', function() {
		var text = $('#text_req').val();
		var showText = $('#show_req').text();
		/*if (text.length < 10) {
			$.alert('Please enter requirements at least 1 words');
		}else if (showText.length < 20) {
			$.alert('I think you forgot to save because you have written something but not saved it yet.');
		}
		else{
			$('#container_req').addClass('hide');
		}*/
		
		$('#container_req').addClass('hide');
		var date = $('#startDate').val();
		if (date.length < 5) {
			$('#startDate').click();
		}
	});

	$(document).on('click', '#save_req', function() {
		var text = $('#text_req').val();
		/*if (text.length < 20) {
			$.alert('Please enter requirements at least 20 words');
		}
		else{*/
			$('#show_req').text(text);
			$('#container_req').addClass('hide');
			var date = $('#startDate').val();
			if (date.length < 5) {
				$('#startDate').click();
			}
		/*}*/
	});

</script>