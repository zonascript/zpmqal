<article id="item-607" class="item" data-permalink="https://demo.yootheme.com/themes/wordpress/2012/subway/?p=607">
	<header>
		<h1 class="title"><a href="index30e4.html?p=607" title="holiday impressions">accommodations</a></h1>
	</header>
	@foreach ($package->accomoRoutes as $key => $route)
		<?php
			$accomo = $route->accomo();
		?>
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
	@endforeach
</article>
<div class="links">
	<a href="{{ $tempUrl }}accommodation" title="show more">show more</a>
</div>