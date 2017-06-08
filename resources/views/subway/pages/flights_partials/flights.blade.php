@if ($package->flightRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">flights</h1>
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
												<div class="m-tb-15-5">
													<div class="vertical-parent">
														<div class="vertical-child div-60" >
															<img src="{{ flightImage($flightDetail->code) }}" alt="{{$flightDetail->name}}">
														</div>
													</div>
												</div>
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
@endif
