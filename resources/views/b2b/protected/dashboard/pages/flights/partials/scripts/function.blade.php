<script>
	function getRidObject(rid) {
		return idObject['flight_'+rid];
	}



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



{{-- move to top --}}

	function moveToTop(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).prepend(thisObj)
							.find('.border-green-2px')
								.removeClass('border-green-2px');

		$(thisObj).find('.x_panel.glowing-border').addClass('border-green-2px');
	}

{{-- /move to top --}}



	function refreashFlights(ids) {
		$('#loging_log').show();
		$('#'+ids.elem_id).append('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button data-vendor="'+ids.vendor+'" data-did="'+ids.did+'" data-rid="'+ids.rid+'" class="btn btn-primary btn-block refreash-flights">Refreash</button></div></div></div>');
	}



	function clickAtab(thisObj) {
		var rid = $(thisObj).attr('data-rid');
		var ridObject = getRidObject(rid);
		var origin = ridObject.origin;
		var destination = ridObject.destination;
		$('#modify_origin').val(origin);
		$('#modify_destination').val(destination);
		$('#modify_search').attr('data-rid', rid);
	}



	function modifySearch(thisObj) {
		$('#loging_log').show();
		var rid = $(thisObj).attr('data-rid');
		var origin = $('input.origin').val();
		var destination = $('input.destination').val();
		changeTabMenu(rid, origin, destination);

		idObject['flight_'+rid].origin = origin; {{--setting attribute here--}}
		idObject['flight_'+rid].destination = destination; {{--setting attribute here--}}
		
		{{--var arrival = $('input.arrival').val();
		var adult = $('input.adult').val();
		var child = $('input.child').val();
		var infant = $('input.infant').val();--}}

		var data = {
				"_token" : csrf_token,
				"origin" : origin,
				"destination" : destination
				{{--"arrival" : arrival,
				"adult" : adult,
				"child" : child,
				"infant" : infant,--}}
			};

		$.ajax({
			type:"post",
			url: "{{url('dashboard/package/route/update/')}}/"+rid+"?format=json",
			data: data,
			success: function(response) {
				var response = JSON.parse(response);
				/*console.log(response);*/
				if (response.status == 200) {
					$('#flight_'+rid).empty();
					postQpxFlight(rid);
					/*postSsFlight(rid);*/
				}
      }
		});
	}




	function addToCart(thisObj) {
		$('#loging_log').show();

		$(thisObj).addClass('btn-danger')
								.removeClass('btn-primary')
									.text('Delete');

		var parent = $(thisObj).closest('.list.list-unstyled'); {{--parent ul element--}}
		$(parent).find('.btn-addtocart.btn-primary')
							 .addClass('btn-dark')
								 .removeClass('btn-primary');
		{{-- $('.btn-addtocart.btn-primary').prop('disabled', false); --}}

		var rid = $(parent).attr('data-rid'); {{-- route id --}}
		var ind = $(thisObj).attr('data-ind'); {{-- index --}}
		var vdr = $(thisObj).attr('data-vdr'); {{-- api vendor --}}
		var vid = $(thisObj).attr('data-vid'); {{-- api vendor db id --}}
		var ridObject = getRidObject(rid);
		var next_rid = ridObject.next_rid;

		var data = {
				"rid" : rid,
				"ind" : ind,
				"vdr" : vdr,
				"vid" : vid,
				"next_rid" : next_rid
			};

		postAddtoCartFlight(data);
		moveToTop($(thisObj).closest('.main-list-item'));
	}
	


	function postAddtoCartFlight(dataObj) {

		var data = {
				"ind" : dataObj.ind,
				"vdr" : dataObj.vdr,
				"vid" : dataObj.vid,
				"_token" : csrf_token
			};

		$.ajax({
			type	: "post",
			url 	:	"{{ urlFlightBook() }}"+dataObj.rid,
			data 	: data,
			success : function(responce){
				responce = JSON.parse(responce);
				if (responce.status == 200) {
					if (dataObj.next_rid != "NaN") {
						setTimeout(function () {
							if (isPulled(dataObj.next_rid) == 0) {
								postQpxFlight(dataObj.next_rid);
								/*postSsFlight(next_rid);*/
							}
							else{
								$('#loging_log').hide();
							}
					  }, 2000);
					}
					else{
						setTimeout(function () {    
							document.location.href = "{{ url('dashboard/package/builder/event/'.$package->token.'/flight') }}";
					  }, 2000)
					}
					clickNext(dataObj.next_rid);
				}
				else{
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



	function getFlightStack(flight) {
		var appendHtml = '';
		var searchWord = '';
		@include($viewPath.'.partials.scripts.html')
		return appendHtml;
	}




	function dataIsPulled(rid) {
		$('#flight_'+rid).attr('data-ispulled', 1);
	}

	function isPulled(rid) {
		return $('#flight_'+rid).attr('data-ispulled');
	}


	function changeTabMenu(rid, origin, destination) {
		var originCode = origin.substring(0,3);
		var destinationCode = destination.substring(0,3);
		$('#a_flight_'+rid).text(originCode+' → '+destinationCode);
	}


	function clickNext(rid) {
		$('#a_flight_'+rid).click();
	}
</script>


@include($viewPath.'.partials.scripts.qpx')
@include($viewPath.'.partials.scripts.ss')