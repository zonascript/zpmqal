<?php 
	$segments = $flight->qpxFlight->segments;
?>
<div class="border-gray m-top-20px">
	<table width="100%">
	@foreach ($segments as $segment)
		<tr>
			<td width="40%">
				<table width="100%">
						<tr>
							<td width="30%">
								<div>
									<img 
										src="{{ urlImageAirline($segment->airline->carrier) }}" 
										alt="{{$segment->airline->carrier}}" 
										style="height: 50px; width:50px;"
									>
								</div>
							</td>
							<td width="70%">
								<div>
									<div>{{ $segment->airline->name }}</div>
									<div>
										<small class="m-top-10px">
											{{ $segment->airline->carrier.$segment->airline->number }}
										</small>
									</div>
								</div>
							</td>
						</tr>
				</table>
			</td>
			<td width="30%">
				<table width="100%">
						<tr>
							<td>
								<div>{{ $segment->departureDateTime->time }}</div>
								<div class="{{-- m-top-10px --}}">
									<small>
										{{ date_formatter($segment->departureDateTime->date, null, 'd/m/Y') }}
									</small>
								</div>
							</td>
							<td>
								<div>{{ $segment->arrivalDateTime->time }}</div>
								<div class="{{-- m-top-10px --}}">
									<small>
										{{ date_formatter($segment->arrivalDateTime->date, null, 'd/m/Y') }}
									</small>
								</div>
							</td>
						</tr>
				</table>
			</td>
			<td>
				<span>{{$segment->origin}} → {{$segment->destination}}</span>
			</td>
		</tr>
	@endforeach
	</table>
</div>
