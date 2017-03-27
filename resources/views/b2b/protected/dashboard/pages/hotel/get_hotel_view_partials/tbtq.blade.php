<?php 
	$html = 'return \'<li class="m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
					<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
						<img src="\'+hotelImage+\'" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="nopadding hotelName">\'+hotelName+\'</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>\'+sortHotelAddress+\'</span> 
							<span> | </span> 
							<span>
								<a id="btn-showMap" class="btn-link cursor-pointer">Map</a>
							</span>
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

					</h2>
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
							<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Choose Room" data-hotelIndex="\'+i+\'" 
								data-vendor="tbtq" data-uid="\'+uniqueKey+\'"
							/>
						</div>
					</div>
				</div>
			</div>
			<div id="hoteldetail-\'+uniqueKey+\'" class="col-md-12 col-sm-12 col-xs-12 nopadding classHotelDetail" style="display: none;">
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
					<div id="exTab1" class="container">
						<ul  class="nav nav-pills">
							<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
								<a  href="#\'+uniqueKey+\'_\'+uniqueKey+\'a" data-toggle="tab">Rooms</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#\'+uniqueKey+\'_\'+uniqueKey+1+\'a" data-toggle="tab">About</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#\'+uniqueKey+\'_\'+uniqueKey+2+\'a" data-toggle="tab">Map</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#\'+uniqueKey+\'_\'+uniqueKey+3+\'a" data-toggle="tab">Gallary</a>
							</li>
						</ul>
						<div id="main_hotelDetail_\'+uniqueKey+\'" class="tab-content main-hotelDetail scroll-bar clearfix">
							<div class="tab-pane active" id="\'+uniqueKey+\'_\'+uniqueKey+\'a">
								<div id="roomresult-\'+uniqueKey+\'" class="row"></div>
							</div>
							<div class="tab-pane" id="\'+uniqueKey+\'_\'+uniqueKey+1+\'a"></div>
							<div class="tab-pane" id="\'+uniqueKey+\'_\'+uniqueKey+2+\'a"></div>
							<div class="tab-pane" id="\'+uniqueKey+\'_\'+uniqueKey+3+\'a"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</li>\'';

	$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
?>

<script>
	function tbtq() {
		var data = {
				"_token" : "{{ csrf_token() }}",
			}

		$.ajax({
			type:"post",
			url: "{{ urlTbtqResult($packageHotel->id) }}",
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
						html = makeTbtqHtml(i,v);
						$('#hotelResultStack').append(html);
					});
				}
				else{
					return tbtq();
				}



				
			}
		});
	}
</script>

<script>
	function makeTbtqHtml(i, obj) {
		var uniqueKey = 't_'+i;
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