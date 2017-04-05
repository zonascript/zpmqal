<script>
	function getRidObject(rid) {
		return idObject['flight_'+rid];
	}
</script>


<script>
	function qpxDateTime(datetime) {
		var datetime = datetime.split('T');
		var time =  datetime[1].substring(0, 5);
		return {'date':datetime[0], 'time':time };
	}

	function ssDateTime(datetime) {
		var datetime = datetime.split('T');
		var time =  datetime[1].substring(0, 5);
		return {'date':datetime[0], 'time':time};
	}

	function getDate(datetime) {
		return moment(datetime).format("DD-MM-YYYY");
	}

	function getTime(datetime) {
		return moment(datetime).format("HH:mm");
	}
</script>

<script>
	function refreashFlights(ids) {
		$('#loging_log').show();
		$('#'+ids.elem_id).append('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button data-vendor="'+ids.vendor+'" data-did="'+ids.did+'" data-rid="'+ids.rid+'" class="btn btn-primary btn-block refreash-flights">Refreash</button></div></div></div>');
	}
</script>



<script>
	function postAddtoCartFlight(data) {
		/*Object must be like this 
		var data = {
			"_token" : csrf_token,
			"did" : did,
			"index" :id,
			"vendor" : vendor
		}*/
		$.ajax({
			type:"post",
			url: "{{ urlFlightBook()}}"+data.did,
			data: data,
			success : function(responce){
				responce = JSON.parse(responce);
				if (responce.status == 200) {
					if (data.next_rid != "NaN") {
						setTimeout(function () {
							console.log(isPulled(data.next_rid));
							if (isPulled(data.next_rid) == 0) {
								postQpxFlight(data.next_rid);
								/*postSsFlight(next_rid);*/
							}else{
								$('#loging_log').hide();
							}
					  }, 2000)
					}else{
						setTimeout(function () {    
							document.location.href = "{{ url('/dashboard/package/builder/event/'.$package->id.'/flight') }}";
					  }, 2000)
					}
					$('#a_flight_'+data.next_rid).click();
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

<script>
	function getFlightStack(flight) {
		var appendHtml = '';
		var searchWord = '';
		@include('b2b.protected.dashboard.pages.flights.partials.flight_stack')
		return appendHtml;
	}
</script>

<script>
	function dataIsPulled(rid) {
		$('#flight_'+rid).attr('data-ispulled', 1);
	}

	function isPulled(rid) {
		return $('#flight_'+rid).attr('data-ispulled');
	}
</script>

<script>
	function changeTabMenu(rid, origin, destination) {
		var originCode = origin.substring(0,3);
		var destinationCode = destination.substring(0,3);
		$('#a_flight_'+rid).text(originCode+' → '+destinationCode);
	}
</script>


@include('b2b.protected.dashboard.pages.flights.partials.qpx_script')
@include('b2b.protected.dashboard.pages.flights.partials.ss_script')
