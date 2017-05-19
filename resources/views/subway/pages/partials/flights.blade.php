<article id="item-607" class="item" data-permalink="https://demo.yootheme.com/themes/wordpress/2012/subway/?p=607">
	<header>
		<h1 class="title"><a href="index30e4.html?p=607" title="holiday impressions">flights</a></h1>
	</header>
	@foreach ($package->flightRoutes as $key => $route)
		<div class="content clearfix p-10">
			@foreach ($route->flightDetail() as $flightDetail)
				<div class="row">
					<div class="col-md-5 col-sm-5 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-left">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-12">
										<div class="row">
											<img src="{{ flightImage($flightDetail->code) }}" alt="">
										</div>
									</div>
									<div class="col-md-9 col-sm-9 col-xs-12 m-top-15">
										<div class="flightName font-size-15">
											{{ str_replace('Limited', '', $flightDetail->name)  }}
										</div>
										<div class="font-size-10">
											<i>{{ $flightDetail->code.$flightDetail->flightNumber }}</i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">
						<div class="row m-top-15">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="text-center">
									<div class="font-size-15">
										{{ $flightDetail->departureTime }} 
										<span class="font-size-10">
											<i>({{ $flightDetail->departureDate }})</i>
										</span>
									</div>
									<div>
										{{ $flightDetail->origin }} 
										<span class="font-size-10">
											<i>({{ $flightDetail->originCode }})</i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="text-center">
									<div class="font-size-15">
										{{ $flightDetail->arrivalTime }} 
										<span class="font-size-10">
											<i>({{ $flightDetail->arrivalDate }})</i>
										</span>
									</div>
									<div>
										{{ $flightDetail->destination }}
										<span class="font-size-10">
											<i>({{ $flightDetail->destinationCode }})</i>
										</span> 
									</div>
								</div>
							</div>		
						</div>	
					</div>
				</div>
			@endforeach
		</div>
	@endforeach
</article>
<div class="links">
	<a href="{{ $tempUrl }}flight" title="show more">show more</a>
</div>