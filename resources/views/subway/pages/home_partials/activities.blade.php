@if ($package->accomoRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('accommodation') }}" title="holiday impressions">things to do</a>
			</h1>
		</header>
		
		<div class="gi-carousel-main height-250px">
	    <div class="GICarousel carousel-box1 GI_C_wrapper">
	      <ul class="GI_IC_items height-250px" style="{{ $package->accomoRoutes->count() == 1 ? "display: block;" : ''}}">
		      @foreach ($package->activities as $key => $activity)
						@if (($key+1)%3 == 1)
							<li class="height-250px">
						@endif
							<?php $activity = $activity->activityObject(); ?>
							<div class="content clearfix m-top-10">
								<img height="70" width="80" class="align-left" alt="{{ $activity->name }}" src="{{ $activity->image }}" />
								<div class="font-size-17"><b><i>{{$activity->name}}</i></b></div>
								<div>{{ sub_string($activity->description, 120) }}</div>
							</div>
						@if (($key+1)%3 ==0)
							</li>
						@endif
					@endforeach
	      </ul>
	    </div>
	  </div>
		<script type="text/javascript">
			$('.carousel-box1').GICarousel({arrows:true});
  	</script>
	</article>
	<div class="links">
		<a href="{{ $urlObj->url('activities') }}" title="show more">show more</a>
	</div>
@endif
