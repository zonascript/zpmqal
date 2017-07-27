<article class="item">
	<header>
		<h1 class="title">trip summary</h1>
	</header>
	<div class="content clearfix">
		<table width="100%" class="table-lborder table-trip-sum">
			<tr>
				<td>
					<div class="m-top-15"></div>
					@if ($package->flightRoutes->count())
						<strong>Flights Included {{-- ({{$package->flightRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->flightRoutes as $key => $value)
								<?php
									$line = $value->origin_detail->location.' to '.$value->destination_detail->location;
								?>
								@if ($key < 2)
									<li>
										{{ $line }}.
										@if ($key == 1 && $key < ($package->flightRoutes->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $line }}.
										@if ($key == ($package->flightRoutes->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					@endif
					@if ($package->accomoRoutes->count())
						<strong>Hotels Included {{-- ({{$package->accomoRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->accomoRoutes as $key => $value)
								@if ($key < 2)
									<li>
										{{ $value->accomo()->name }}
										@if ($key == 1 && $key < ($package->accomoRoutes->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $value->accomo()->name }}
										@if ($key == ($package->accomoRoutes->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					@endif

					@if ($package->cost->is_visa)
						<strong>Visa Included</strong>
					@endif

				</td>
				<td>
					@if ($package->activities->count())
						<ul>
							@foreach ($package->activities as $key => $value)
								@if ($key < 6)
									<li>
										{{ $value->activityObject()->name }} | {{ proper($value->activityObject()->mode) }} basis.
										@if ($key == 5 && $key < ($package->activities->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $value->activityObject()->name }} | {{ proper($value->activityObject()->mode) }} basis.
										@if ($key == ($package->activities->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					@endif
				</td>
			</tr>
		</table>
	</div>
</article>