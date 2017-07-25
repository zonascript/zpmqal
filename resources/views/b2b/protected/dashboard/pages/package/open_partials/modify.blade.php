<div class="x_panel height-82vh">
	<div class="x_title">
		<div class="row m-top-10">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<h2>Packages</h2>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-12 pull-right">
				<ul class="nav navbar-right panel_toolbox panel_toolbox1">
					<li>
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Package Id</th>
					<th>For</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if($package->routes->count())
					@foreach($package->packages as $mPackageKey => $mPackage)
						<?php 
							$country = isset($mPackage->routes[0]->explode_destination)  
											 ? $mPackage->routes[0]->explode_destination
											 : [];
							$country = end($country);
						?>
						<tr>
							<th scope="row">{{ $mPackageKey+1 }}</th>
							<td>{{ $mPackage->uid }}</td>
							<td>{{ $country }}</td>
							<td>{{ $mPackage->created_at->format('d-M-Y H:i') }}</td>
							<td>
								<a href="{{ route('openPackage', $mPackage->token) }}" class="btn btn-success btn-xs">Open</a>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>

	</div>
</div>