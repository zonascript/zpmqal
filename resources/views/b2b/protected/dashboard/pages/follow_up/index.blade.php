@extends('b2b.protected.dashboard.main')

@section('css')
		{{-- Datatables --}}
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
					{{-- <p class="text-muted font-13 m-b-30">
						DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
					</p> --}}
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Package Id</th>
								<th>Full Name</th>
								<th>Date And Time</th>
								<th>Note</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@forelse ($follow_ups as $follow_up)
								<tr>
									<td>{{ getPackageId($follow_up->packageId) }}</td>
									<td>
										<a href="{{ url('dashboard/package-builder/'.$follow_up->id) }}" target="_blank">{{ $follow_up->fullname }}</a>
									</td>
									<td>{{ $follow_up->datetime }}</td>
									<td>
										{{ sub_string($follow_up->note) }}
									</td>
									<td>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-6 p-right-5">
												<a class="btn btn-success btn-xs btn-block">Edit</a>
											</div>	
											<div class="col-md-6 col-sm-6 col-xs-6 p-left-5">
												<button type="button" class="btn btn-danger btn-xs btn-block">Delete</button>
											</div>
										</div>
									</td>
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

{{-- datatable --}}
@section('js')
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			$('#datatable').dataTable({
					"pageLength": 50,
	       	"order": [[ 2, "asc" ]]
	    	});
		});
	</script>
@endsection
{{-- /datatable --}}
