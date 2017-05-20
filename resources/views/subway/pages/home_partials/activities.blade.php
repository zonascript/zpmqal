@if ($package->activities->count())
	<article id="item-607" class="item" data-permalink="https://demo.yootheme.com/themes/wordpress/2012/subway/?p=607">
		<header>
			<h1 class="title"><a href="index30e4.html?p=607" title="holiday impressions">things to do</a></h1>
		</header>
		@foreach ($package->activities as $activity)
			<?php $activity = $activity->activityObject(); ?>
			<div class="content clearfix m-top-10">
				<img height="70" width="80" class="align-left" alt="{{ $activity->name }}" src="{{ $activity->image }}" />
				<div class="font-size-17"><b><i>{{$activity->name}}</i></b></div>
				<div>{{ sub_string($activity->description, 120) }}</div>
			</div>
		@endforeach
	</article>
	<div class="links">
		<a href="{{ $tempUrl }}activities" title="show more">show more</a>
	</div>
@endif