<?php 
	$html = 'return \'<li class="m-top-10">
		<div class="x_panel glowing-border">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="row height-150px">
						<img src="\'+hotelImage+\'" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="search-word">\'+hotelName+\'</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>\'+sortHotelAddress+\'</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<div class="col-md-4 col-sm-4 col-xs-4 m-top-5 nopadding">
								\'+starRatingHtml+\'
								<div hidden>
									<p class="starRating" >\'+starRating+\'</p>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							\'+sortHotelDescription+\'
							<button id="btn-amenitiesMore" class="btn-link cursor-pointer" 
								data-toggle="modal" data-target=".bs-example-modal-sm" 
								data-title="\'+hotelName+\' : Description" data-bodyid="hotelDescription\'+uniqueKey+\'" 
								data-button="false">More
							</button>
							<div id="hotelDescription\'+uniqueKey+\'" hidden>\'+hotelDescription+\'</div>
						</div>
					</div>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12">
					<div class="row">'.

						/*<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
							<div class="fixed-tooltip btn-block">
								<span class="fixed-tooltiptext font-size-10 bg-color-lightcoral">All NIGHT PRICE</span>
							</div>
							<h3 class="text-center m-top-5">
								<i class="fa fa-rupee font-size-20"></i>
								<span class="hotelPrice">\'+hotelPrice+\'</span>
							</h3>
						</div>*/

						'<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
							<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Rooms" 
								data-vendor="tbtq" 
								data-did="\'+ids.did+\'" 
								data-uid="\'+uniqueKey+\'"
								data-hotelIndex="\'+i+\'" 
								data-elemid="\'+ids.elem_id+\'" 
							/>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="hoteldetail-\'+uniqueKey+\'" class="col-md-12 col-sm-12 col-xs-12 classHotelDetail" style="display: none;">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div id="exTab1" class="container">
								<ul  class="nav nav-pills">
									<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
										<a href="#\'+uniqueKey+\'a" data-toggle="tab">Rooms</a>
									</li>
									<li class="col-md-2 col-sm-2 col-xs-12 text-center">
										<a href="#\'+uniqueKey+\'b" data-toggle="tab">About</a>
									</li>
									<li class="col-md-2 col-sm-2 col-xs-12 text-center">
										<a href="#\'+uniqueKey+\'c" data-toggle="tab">Map</a>
									</li>
									<li class="col-md-2 col-sm-2 col-xs-12 text-center">
										<a href="#\'+uniqueKey+\'d" data-toggle="tab">Gallary</a>
									</li>
								</ul>
								<div id="main_hotelDetail_\'+uniqueKey+\'" class="tab-content main-hotelDetail scroll-bar clearfix">
									<div id="\'+uniqueKey+\'a" class="tab-pane active"></div>
									<div id="\'+uniqueKey+\'b" class="tab-pane"></div>
									<div id="\'+uniqueKey+\'c" class="tab-pane"></div>
									<div id="\'+uniqueKey+\'d" class="tab-pane"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</li>\'';

	$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
?>

<script>
	function tbtq(did, rid) {
		var elem_id = "hotel_"+rid;
		var ids = {
				'did' : did,
				'elem_id' : elem_id
			};

		var data = {
				"_token" : "{{ csrf_token() }}",
			}

		$.ajax({
			type:"post",
			url: "{{ url('/t/hotels/result') }}/"+did,
			data: data,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				// console.log(responce);
				var html = '';
				var hotels = [];
				if (responce.HotelSearchResult.ResponseStatus == 1) {
					hotels = responce.HotelSearchResult.HotelResults;
				}
				
				if (hotels.length) {
					$('#loging_log').hide();

					$.each(hotels, function(i,v){
						html = makeTbtqHtml(i,v, ids);
						$('#'+elem_id).append(html);
					});
					filter.initFilter(rid);
				}
				else{
					return tbtq(did, rid);
				}

			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					tbtq(did, rid);
					// $('#loging_log').hide();
					// $('#'+elem_id).html('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button class="btn btn-primary btn-block" onclick="'+tbtq(did, rid)+';">Refreash</button></div></div></div>');
				}
			}
		});
	}
</script>

<script>
	function makeTbtqHtml(i, obj, ids) {
		var uniqueKey = obj.HotelCode;
		var uniqueKey = uniqueKey.replace("|", "_");
		var hotelName = obj.HotelName;
		var hotelImage = '';
		hotelImage = obj.HotelPicture;
		var hotelPrice = obj.Price.PublishedPriceRoundedOff;
		var hotelAddress = obj.HotelAddress; 
		var sortHotelAddress = hotelAddress.substring(0, 40);
		var hotelDescription = obj.HotelDescription;
		var sortHotelDescription = hotelDescription.substring(0, 120);
		var starRating = obj.StarRating;
		var starRatingHtml = star_Rating(starRating);

		<?php echo $html; ?>
	}
</script>