
<script>
	function postRoute() {
		if (checkInputs()) {
			$('.destinationList.no-rid').each(function(){
				var rid = $(this).attr("data-rid");
				var mode = $(this).find('.mode').val();
				var origin = $(this).find('.origin').val();
				var destination = $(this).find('.destination').val();
				var nights = $(this).find('.nights').val();
				var origin_time = $(this).find('.origin-time').val();
				var destination_time = $(this).find('.destination-time').val();
				var pid = $('#startDate').attr('data-pid');
				var thisElem = $(this);

				var data = {
					"_token" : csrf_token,
					"rid" : rid,
					"mode" : mode,
					"origin" : origin,
					"origin_time" : origin_time,
					"destination" : destination,
					"destination_time" : destination_time,
					"nights" : nights,
				};

				$.ajax({
					type:"post",
					url: "{{ url('dashboard/package/route') }}/"+pid+"/r", 
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