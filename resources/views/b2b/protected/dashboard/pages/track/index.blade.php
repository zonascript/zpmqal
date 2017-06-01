@extends('b2b.protected.dashboard.main')

@section('content')
	<div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Tracks <small>(Package Status)</small></h2>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Package Id</th>
									<th>Client Name</th>
									<th>Read Time</th>
								</tr>
							</thead>
							<tbody>
							@foreach($tracks as $trackKey => $track)
								<tr>
									<th scope="row">{{$trackKey+1}}</th>
									<td>{{ $track->package->uid }}</td>
									<td>{{ $track->package->client->fullname }}</td>
									<td>{{ $track->created_at }}</td>
									<td>
										<div class="col-md-6 col-sm-6 col-xs-12 pull-right">
											<a href="{{ route('openPackage', $track->package->token) }}" class="btn btn-block btn-success btn-xs">Open</a>
										</div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>  
@endsection