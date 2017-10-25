<?php 
	$default = $package->tripSummary();
	$compareTo = $package->comparePackage(request()->compare_token);
	$checkAttrs = ['flights', 'hotels', 'transfers', 'activities'];
?>

<article class="item">
	<header>
		<h1 class="title">Compare</h1>
	</header>
	<div class="content clearfix p-10">
		<div class="x_content sans-serif">
			<div class="content clearfix">
				<table width="100%" class="table-lborder table-trip-sum">
					<tr>
						<td><h2 class="text-center">{{ $package->uid }}</h2></td>
						<td><h2 class="text-center">{{ $compareTo['uid'] }}</h2></td>
					</tr>
					@foreach ($checkAttrs as $checkAttr)
						<?php
							$check = isset($default[$checkAttr]) 
										&& isset($compareTo[$checkAttr])
										&& (!empty($default[$checkAttr]) 
										|| !empty($compareTo[$checkAttr]));
						?>
						@if ($check)
							<tr>
								<td>
									<h4>{{ proper($checkAttr) }}</h4>
									<ul class="list-unstyled">
										@foreach ($default[$checkAttr] as $value)
											<li>{{ $value }}</li>
										@endforeach
									</ul>
								</td>
								<td>
									<h4>{{ proper($checkAttr) }}</h4>
									<ul class="list-unstyled">
										@foreach ($compareTo[$checkAttr] as $value)
											@if ($value['which'] == 'same')
												<li>{{ $value['same'] }}</li>
											@elseif($value['which'] == 'changed')
												<li><del>{{ $value['same'] }}</del></li>
												<li>{{ $value['changed'] }}</li>
											@elseif($value['which'] == 'new')
												<li style="color: #aef3ae;">{{ $value['new'] }}</li>
											@endif
										@endforeach
									</ul>
								</td>
							</tr>
						@endif
					@endforeach
					<tr>
						<td>
							<h4>Visa</h4>
							<ul>
								<li>{{ $default['visa'] ? 'Visa included' : 'Visa not included' }}</li>
							</ul>
						</td>
						<td>
							<h4>Visa</h4>
							<ul>
								<li>{{ $compareTo['visa'] ? 'Visa included' : 'Visa not included' }}</li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</article>

