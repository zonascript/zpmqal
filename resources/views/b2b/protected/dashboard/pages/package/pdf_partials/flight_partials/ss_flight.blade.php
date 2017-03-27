<?php 
	$segments = $flight->ssFlight->segments;
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
										src="{{ urlImageAirline($segment->CarrierDetail->Code) }}" 
										alt="{{$segment->CarrierDetail->Code}}" 
										style="height: 50px; width:50px;"
									>
								</div>
							</td>
							<td width="70%">
								<div>
									<div>{{ $segment->CarrierDetail->Name }}</div>
									<div>
										<small class="m-top-10px">
											{{ $segment->CarrierDetail->Code.$segment->FlightNumber }}
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
								<div>{{ $segment->DepartureTiming->time }}</div>
								<div class="{{-- m-top-10px --}}">
									<small>
										{{ date_formatter($segment->DepartureTiming->date, null, 'd/m/Y') }}
									</small>
								</div>
							</td>
							<td>
								<div>{{ $segment->ArrivalTiming->time }}</div>
								<div class="{{-- m-top-10px --}}">
									<small>
										{{ date_formatter($segment->ArrivalTiming->date, null, 'd/m/Y') }}
									</small>
								</div>
							</td>
						</tr>
				</table>
			</td>
			<td>
				<span>{{$segment->Origin->Code}} → {{$segment->Destination->Code}}</span>
			</td>
		</tr>
	@endforeach
	</table>
</div>
