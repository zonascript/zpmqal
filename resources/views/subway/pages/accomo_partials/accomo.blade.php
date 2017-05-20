@if ($package->accomoRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $tempUrl }}accommodation" title="holiday impressions">accommodations</a>
			</h1>
		</header>
		
    @foreach ($package->accomoRoutes as $key => $route)
			<?php
				$images = $route->fusion->images();
				$accomo = $route->accomo();
				$images[] = $accomo->image;
				$images = array_unique($images);
			?>
			<div class="content clearfix">
			  <div class="width-30-p height-200px pull-left m-right-10">
					<div class="gi-carousel-main">
				    <div class="GICarousel demo1 GI_C_wrapper">
				      <ul class="GI_IC_items" style="{{ $package->accomoRoutes->count() == 1 ? "display: block;" : ''}}">
								@foreach ($images as $image)
									<li>
										<img height="195" width="100%" class="align-left" alt="Hotel Image" src="{{ $image }}" />
									</li>
								@endforeach
				      </ul>
				    </div>
				  </div>
			  </div>
			  <div class="">
					<h2 class="m-top-5">{{ $accomo->name }} {!! $accomo->starRatingHtml !!} <small>({{$route->mode}})</small></h2>
					<p>
						<div>{{ $accomo->startDate }} - {{ $accomo->endDate }}</div>
						<div>{{ $accomo->location }}</div>
					</p>
					<p>{{ $accomo->description }}</p>
			  </div>
			</div>
		@endforeach
		<script type="text/javascript">
			$('.demo1').GICarousel({arrows:true});
	   </script>
	</article>
@endif
