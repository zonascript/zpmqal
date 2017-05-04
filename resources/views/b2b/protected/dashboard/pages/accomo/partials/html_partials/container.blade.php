<li class="m-top-10 main-list-item li_'+accomo.ukey+'">
	<div class="x_panel glowing-border">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-150px">
					<img src="'+accomo.image+'" alt="" height="100%" width="100%">
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="search-word">'+accomo.name+' '+accomo.starRatingHtml+'</h3>
						<p class="starRating" hidden>'+accomo.starRating+'</p>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						<i class="fa fa-map-marker"></i>
						<span> '+accomo.sortAddress+'</span>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						'+accomo.sortDescription+'
						<button class="btn-link cursor-pointer description" 
							data-title="'+accomo.name+' : Description" 
							data-bodyid="description'+accomo.ukey+'">More
						</button>
						<div id="description'+accomo.ukey+'" hidden>'+accomo.description+'</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
						<button 
							class="btn '+accomo.btnClass+' btn-block btn-chooseProp off" 
							data-fid="'+accomo.code+'"
							data-fdid="'+accomo.fdid+'" {{-- package_hotel_id --}}
							data-vdr="'+accomo.vendor+'">'+accomo.btnName+'
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row hotel-detail off" style="display: none;">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div id="exTab1" class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a href="#'+accomo.ukey+'_'+accomo.ridObj.rid+'_props" data-toggle="tab">'+accomo.propTabName+'</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+accomo.ukey+'_'+accomo.ridObj.rid+'_about" data-toggle="tab">About</a>
								</li>';
								if(accomo.ridObj.mode == 'hotel'){
									appendHtml += '<li class="col-md-2 col-sm-2 col-xs-12 text-center">
										<a href="#'+accomo.ukey+'_'+accomo.ridObj.rid+'_map" data-toggle="tab">Map</a>
									</li>';
								}
								appendHtml += '<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+accomo.ukey+'_'+accomo.ridObj.rid+'_gallary" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div class="tab-content tab-container scroll-bar clearfix">
								<div id="'+accomo.ukey+'_'+accomo.ridObj.rid+'_props" class="tab-pane active"></div>
								<div id="'+accomo.ukey+'_'+accomo.ridObj.rid+'_about" class="tab-pane">
									'+accomo.description+'
								</div>
								<div id="'+accomo.ukey+'_'+accomo.ridObj.rid+'_map" class="tab-pane" data-src="https://maps.google.com/maps?q='+accomo.latitude+','+accomo.longitude+'&hl=es;z=14&amp;output=embed"></div>
								<div id="'+accomo.ukey+'_'+accomo.ridObj.rid+'_gallary" class="tab-pane">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel">
											<div class="x_content" >
												<div class="gallery cf"></div>
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