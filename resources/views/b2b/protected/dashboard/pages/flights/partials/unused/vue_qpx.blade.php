<ul class="list list-unstyled" v-if="tripOptions.length > 0">
	<li class="min-height-110px" v-for="(tripOption, tripOptionKey) in tripOptions">
		<div class="x_panel glowing-border">
			<div class="col-md-10 col-sm-10 col-xs-12">
				<div v-for="slice in tripOption.slice">
					<div v-for="segment in slice.segment">
						<div class="search-word">@{{carrier[segment.flight.carrier] +' '+segment.flight.carrier + segment.flight.number}}</div>
						<div class="row">
							<div class="col-md-5 col-sm-5 col-xs-12">
								<div class="row m-tb-10px text-left">
									<div class="col-md-3 col-sm-3 col-xs-12">
										<div class="row">
											<img v-bind:src="imageUrl(segment.flight.carrier)" alt="">
										</div>
									</div>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<div class="flightName font-size-15" v-text="carrier[segment.flight.carrier]"></div>
										<div>
											<small v-text="segment.flight.carrier + segment.flight.number"></small>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<div class="row" v-for="leg in segment.leg">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<h2>
												<span v-text="getTime(leg.departureTime)"></span>
												<small v-text="'('+getDate(leg.departureTime)+')'"></small>
											</h2>
											<div v-text="leg.origin"></div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<h2>
												<span v-text="getTime(leg.arrivalTime)"></span>
												<small v-text="'('+getDate(leg.arrivalTime)+')'"></small>
											</h2>
											<div v-text="leg.destination"></div>
										</div>
									</div>		
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<h2 class="flightPrice text-center">
					{{-- <i class="fa fa-rupee"></i> --}}
					{{-- <span>{{ ifset($tripOption->saleTotal) }}</span> --}}
					{{-- <span>/-</span> --}}
				</h2>
				<div class="row m-tb-20px">
					<button class="btn btn-primary btn-block btn-bookFlight" v-bind:data-bookIndex="tripOptionKey" data-vendor="qpx">Select</button>
				</div>
			</div>
		</div>
	</li>
</ul>
