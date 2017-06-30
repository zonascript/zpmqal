<article class="item">
	<header>
		<h1 class="title">trip summary</h1>
	</header>
	<div class="content clearfix">
		<table width="100%" class="table-lborder table-trip-sum">
			<tr>
				<td>
					<ul>
						@if ($package->flightRoutes->count())
							<li>Flights Included</li>
						@endif
						@if ($package->hotelRoutes->count())
							<li>Hotels Included</li>
						@endif
						@if ($package->cruiseRoutes->count())
							<li>Cruise Included</li>
						@endif
						@if ($package->activities->count())
							<li>Activities Included</li>
						@endif
						@if ($package->cost->is_visa)
							<li>Visa Included</li>
						@endif
					</ul>
				</td>
				<td>
					@if ($package->activities->count())
						<ul>
							@foreach ($package->activities as $key => $value)
								<li>
									{{ $value->activityObject()->name }}.
									@if ($key == 4 && $key < ($package->activities->count()-1))
										... <a href="{{ $urlObj->url('activities') }}">more</a>
										@break
									@endif
								</li>
							@endforeach
						</ul>
					@endif
				</td>
			</tr>
		</table>

		
	</div>
</article>