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
					<h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="search-word">\'+hotelName+\'</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4 m-top-5">
									\'+starRatingHtml+\'
									<div hidden>
										<p class="starRating" >\'+starRating+\'</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<b>Amenities : </b> \'+amtis+\'
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
							<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Rooms" 
								data-vendor="ss" 
								data-did="\'+ids.did+\'"
								data-uid="\'+uniqueKey+\'"
								data-elemid="\'+ids.elem_id+\'" 
								data-hotelIndex="\'+i+\'" 
							/>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="hoteldetail-\'+uniqueKey+\'" class="col-md-12 col-sm-12 col-xs-12 classHotelDetail" style="display: none;">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="container">
								<ul  class="nav nav-pills">
									<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
										<a  href="#\'+uniqueKey+\'a" data-toggle="tab">Rooms</a>
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
	function sshtl(did, rid) {
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
			url: "{{ url('/ss/hotels/result/') }}/"+did,
			data: data,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				// console.log(responce);
				var html = '';
				var hotels = responce.hotels;
				// console.log(hotels.length);
				if (hotels.length) {
					$('#loging_log').hide();

					$.each(hotels, function(i,v){
						html = makeSsHtml(i, v, responce.amenities, ids);
						$('#'+elem_id).append(html);
					});
					filter.initFilter(rid);
				}
				else{
					return sshtl(did, rid);
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					sshtl(did, rid);
					// $('#loging_log').hide();
					// $('#'+elem_id).html('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button class="btn btn-primary btn-block" onclick="'+sshtl(did, rid)+';">Refreash</button></div></div></div>');
				}
			}
		});
	}
</script>


<script>
	function makeSsHtml(i, obj, amenities, ids) {
		// console.log(amenities);
		var uniqueKey = obj.hotel_id;
		var hotelName = obj.name;
		var hotelAddress = obj.address; 
		var sortHotelAddress = hotelAddress.substring(0, 40);
		var hotelDescription = '';
		var sortHotelDescription = hotelDescription.substring(0, 120);
		var starRating = obj.star_rating;
		var starRatingHtml = star_Rating(starRating);
		var hotelImageArray = obj.image_urls[0].split(':{');
		var hotelImage = hotelImageArray[0].replace("{", "");

		if (hotelImage.indexOf('{') != -1 || hotelImage.indexOf('}') != -1) {
			hotelImage = "{{ urlDefaultImageHotel() }}";
		}else{
			hotelImage = 'http://'+hotelImage+'rmc.jpg';
		}
		amtisArray = [];
		
		$.each(obj.amenities, function(amtisKey, amtisValue){
			amenitiesName = amenities[amtisValue]

			amtisArray.push(amenitiesName.name);
		});

		amtis = amtisArray.join(', ');
		amtis = amtis.substring(0, 120);
		<?php echo $html; ?>
	}
</script>