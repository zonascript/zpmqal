<li class="m-top-10 main-list-item">
	<div class="x_panel glowing-border">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-150px">
					<img src="'+hotelImage+'" alt="" height="100%" width="100%">
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="search-word">'+hotelName+'</h3>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						<i class="fa fa-map-marker"></i>
						<span>'+sortHotelAddress+'</span>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 ">
						<div class="col-md-4 col-sm-4 col-xs-4 m-top-5 nopadding">
							'+starRatingHtml+'
							<div hidden>
								<p class="starRating" >'+starRating+'</p>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						'+sortHotelDescription+'
						<button id="btn-amenitiesMore" class="btn-link cursor-pointer" 
							data-toggle="modal" data-target=".bs-example-modal-sm" 
							data-title="'+hotelName+' : Description" data-bodyid="hotelDescription'+uniqueKey+'" 
							data-button="false">More
						</button>
						<div id="hotelDescription'+uniqueKey+'" hidden>'+hotelDescription+'</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
						<button 
							class="btn btn-primary btn-block btn-chooseRoom" 
							data-vendor="a" 
							data-did="'+ids.did+'" 
							data-uid="'+uniqueKey+'"
							data-hid="'+hotel_id+'"
							data-isadd="0"
							data-index="'+i+'" 
							data-elemid="'+ids.elem_id+'">Rooms
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="hoteldetail-'+uniqueKey+'" class="col-md-12 col-sm-12 col-xs-12 classHotelDetail" style="display: none;">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div id="exTab1" class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a href="#'+uniqueKey+'_rooms" data-toggle="tab">Rooms</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+uniqueKey+'_about" data-toggle="tab">About</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+uniqueKey+'_map" data-toggle="tab">Map</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+uniqueKey+'_gallary" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div id="main_hotelDetail_'+uniqueKey+'" class="tab-content main-hotelDetail scroll-bar clearfix">
								<div id="'+uniqueKey+'_rooms" class="tab-pane active"></div>
								<div id="'+uniqueKey+'_about" class="tab-pane"></div>
								<div id="'+uniqueKey+'_map" class="tab-pane" data-src="https://maps.google.com/maps?q='+latitude+','+longitude+'&hl=es;z=14&amp;output=embed"></div>
								<div id="'+uniqueKey+'_gallary" class="tab-pane">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel">
											<div class="x_content" >
												<div id="'+uniqueKey+'_gimg" class="gallery cf"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>