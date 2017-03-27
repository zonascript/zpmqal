
{{-- did == db id --}}
<script>
	function postSsFlight(did = '', rid ='') {
		var elem_id = "flight_"+rid;
		var ids = {
				'did' : did,
				'rid' : rid,
				'vendor' : 'ss',
				'elem_id' : elem_id
			};

		$.ajax({
			type:"post",
			url: "{{ url('ss/flights/result') }}/"+did,
			data: { "_token" : csrf_token },

			success: function(responce, textStatus, xhr) {
					var responce = JSON.parse(responce);
					$('#sorry_error').remove();
					if (responce.hasOwnProperty('Legs') && responce.Legs.length) {
						/*console.log(Object.keys(responce.Carriers).length);*/
						$('#loging_log').hide();

						$.each(responce.Legs, function(i,v){
							var html = '';
							html = makeSsHtml(i, v, responce, ids);
							$('#'+elem_id).append(html);
						});

					}
					else{
						postSsFlight(did, rid);
						/*refreashFlights(ids);*/
					}

					filter.initFilter(rid);

			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					$('#loging_log').hide();
					refreashFlights(ids);
				}
			}
		});
	}
</script>


<script>
	function ssDateTime(datetime) {
		var datetime = datetime.split('T');
		var time =  datetime[1].substring(0, 5);
		return {'date':datetime[0], 'time':time};
	}
</script>

<script>
	function makeSsHtml(legKey,leg, data, ids) {

		if (leg.hasOwnProperty('SegmentIds') && data.hasOwnProperty('Segments')) {
			var segmentsIds = leg.SegmentIds;
			var appendHtml = '';
			var airlines = data.airlines;
			var searchWord = '';
			@include('b2b.protected.dashboard.pages.flights.partials.ss_partials.html')
			return appendHtml;
		}
	}
</script>

