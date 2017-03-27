@extends('b2b.protected.dashboard.main')

@section('css')
		<!-- Datatables -->
		<link href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Client List</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Client ID</th>
								<th>Full Name</th>
								<th>Mobile No.</th>
								<th>Email Id</th>
								<th>Opening Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@forelse ($clients as $client)
								<tr>
									<a href="">
										
									<td>{{ $client->uid }}</td>
									<td>{{ $client->fullname }}</td>
									<td>{{ $client->mobile }}</td>
									<td>{{ $client->email }}</td>
									<td>{{ $client->created_at }}</td>
									<td>{{ $client->status }}</td>
									<td>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-6 p-right-5">
												<a href="{{ url('dashboard/package/all/'.$client->id) }}" class="btn btn-success btn-xs btn-block">Open</a>
											</div>	
											<div class="col-md-6 col-sm-6 col-xs-6 p-left-5">
												<button type="button" class="btn btn-danger btn-xs btn-block">Delete</button>
											</div>
										</div>
									</td>
									</a>
								</tr>
							@empty
							    <p>No users</p>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<!-- Datatables -->
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section('scripts')
	<!-- Datatables -->
	<script>
		$(document).ready(function() {
			$('#datatable').dataTable({
				"pageLength": 50
			});
		});
	</script>
	<!-- /Datatables -->
@endsection