{{-- create package after selecting date --}}
<script>
	$('.datepicker').on('apply.daterangepicker', function(ev, picker) {
		var pid = $(this).attr('data-pid');
		console.log(pid.length);
		if (pid.length == 0 || pid == '') {
			$.ajax({
				type:"post",
				url: "{{ Request::url() }}/c", 
				data: {"_token" : csrf_token},
				success: function(responce) {
					$('#startDate').attr('data-pid', responce);
        }
			});
		}
	});
</script>
{{-- /create package after selecting date --}}



{{-- Adding or Removing-room --}}
<script>
	$(document).on('click','#btn-addRoom',function(){
		var currentRoom = $('#room').children(":visible").length;
	
		$('#room_'+(currentRoom+1)).show();
		
		if(currentRoom == 1){
			$('#btn-removeRoom, #pipeSapr').show();
		}
		if(currentRoom == 3){
			$('#btn-addRoom, #pipeSapr').hide();
		}
	});

	$(document).on('click','#btn-removeRoom',function(){
		var currentRoom = $('#room').children(":visible").length;

		$('#room_'+(currentRoom)).hide();
		
		if(currentRoom == 2){
			$('#btn-removeRoom, #pipeSapr').hide();
		}
		if(currentRoom == 4){
			$('#btn-addRoom, #pipeSapr').show();
		}
	});
</script>
{{-- /Adding or Removing-room --}}


{{-- remove destination button --}}

<script>
	$('#btn-removeDestination').click(function(){
		var totalDestination = $('.destinationClass').children().length;
		$('#destination'+totalDestination).remove();

		if(totalDestination == 2){
			$('#btn-removeDestination, #pipeSaprDestination').hide();
		}
	});
</script>
{{-- /remove destination button --}}
