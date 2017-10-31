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

		$('#btn-addDestination').click(function(){
		if (postRoute()) {
			saveDate();
			savePackageTitle();
			savePackageReq();
			/*var totalDestination = $('.destinationClass').children().length;*/
			var destinationListHtml = $('#destinationListHtml').html();
			var data_destination_count = addDestCount();
			var destinationId = 'destination'+data_destination_count;
			var inputDestinationId = 'inputDestination'+data_destination_count;

			destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
			destinationListHtml = destinationListHtml.replace('selectNight_temp', 'selectNight');
			destinationListHtml = destinationListHtml.replace('destinationList_temp', 'destinationList');
			destinationListHtml = destinationListHtml.replace('destination_count', destinationId);
			destinationListHtml = destinationListHtml.replace('inputDestination_count', inputDestinationId);
			
			/*$('.destinationClass').append(destinationListHtml);*/
			$(this).closest('.destinationList').after(destinationListHtml);
			
			/*if(totalDestination == 1){
				$('#btn-removeDestination, #pipeSaprDestination').show();
			}*/
		}
	});

</script>