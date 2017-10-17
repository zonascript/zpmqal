@if ($package->activities->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('activities') }}" title="holiday impressions">things to do</a>
			</h1>
		</header>
	  @foreach ($package->activities as $key => $activityData)

			<?php
				$images = [];
				$activity = $activityData->activityObject(['images']);
				$images = $activity->images;
			?>
			
			<div class="content clearfix">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
					  <div class="width-30-p height-200px pull-left m-right-10">
							<div class="gi-carousel-main">
						    <div class="GICarousel carousel-box{{$key}} GI_C_wrapper">
						      <ul class="GI_IC_items" style="{{ count($images) == 1 ? "display: block;" : ''}}">
										@foreach ($images as $image)
											<li>
												<img height="195" width="100%" class="align-left" alt="Activity Image" src="{{ $image }}" onerror="defaultImage(this, '{{ urlDefaultImageActivity() }}')" />
											</li>
										@endforeach
						      </ul>
						    </div>
						  </div>
					  </div>
					  <div>
							<h2 class="m-top-5">{{ $activity->name }}</h2>
							<p>
								<div>
									<ul class="pipe">
										<li>{{ $activity->date }}</li>
										<li>{{ activityMode($activity->mode) }}</li>
										<li>{{ activityTiming($activity->timing) }}</li>

										@if (!is_null($activity->pick_up))
											<li>Pick Up : {{ $activity->pick_up }}</li>
										@endif

										@if (!is_null($activity->duration))
											<li>Duration : {{ $activity->duration }}</li>
										@endif
									</ul>
								</div>
								<br>
							</p>

							<p>{!! $activity->description !!}</p>
					  </div>
				  </div>
				</div>
			  @if (strlen($activity->inclusion))
				  <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
						  <p><label>Inclusion : </label>{!! $activity->inclusion !!}</p>
						</div>
					</div>
			  @endif
			  @if (strlen($activity->exclusion))
				  <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
				  		<p><label>Exclusion : </label>{!! $activity->exclusion !!}</p>
				  	</div>
				  </div>
			  @endif
	
			</div>
			<script type="text/javascript">
				$('.carousel-box{{$key}}').GICarousel({arrows:true,carousel:true});
			</script>
			@if ($package->activities->count() != ($key+1))
				<hr>
			@endif
		@endforeach
	</article>
	<style>
		.GI_C_prev,.GI_C_next{
			background: rgba(0,0,0,0.6) !important;
		}
	</style>
@endif
