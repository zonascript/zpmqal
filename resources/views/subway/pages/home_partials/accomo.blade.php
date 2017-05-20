@if ($package->accomoRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $tempUrl }}accommodation" title="holiday impressions">accommodations</a>
			</h1>
		</header>
		
		<div class="gi-carousel-main">
	    <div class="GICarousel demo1 GI_C_wrapper">
	      <ul class="GI_IC_items" style="{{ $package->accomoRoutes->count() == 1 ? "display: block;" : ''}}">
		      @foreach ($package->accomoRoutes as $key => $route)
						<?php
							$accomo = $route->accomo();
						?>
		        <li>
							<div class="content clearfix">
								<img height="195" width="195" class="align-left" alt="{{ $accomo->name }}" src="{{ $accomo->image }}" />
								<h2 class="m-top-5">{{ $accomo->name }} {!! $accomo->starRatingHtml !!} <small>({{$route->mode}})</small></h2>
								<p>
									<div>{{ $accomo->startDate }} - {{ $accomo->endDate }}</div>
									<div>{{ $accomo->location }}</div>
								</p>
								<p>{{ $accomo->shortDescription }}</p>
							</div>
							@if ($package->accomoRoutes->count() != ($key+1))
								@if ($key == 3)
									@break
								@endif
								<hr>
							@endif
						</li>
					@endforeach
	      </ul>
	    </div>
	  </div>
		<script type="text/javascript">
			$('.demo1').GICarousel({arrows:true});
  	</script>
	</article>
	<div class="links">
		<a href="{{ $tempUrl }}accommodation" title="show more">show more</a>
	</div>
@endif
