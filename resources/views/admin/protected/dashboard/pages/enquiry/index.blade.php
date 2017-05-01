@extends('admin.protected.dashboard.main')

@section('css')
		{{-- Datatables --}}
		<link href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<h2>Client List</h2>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<a href="{{url('dashboard/enquiry/create')}}" class="btn btn-success btn-block">Add New Enquiry</a>
						</div>
					</div>
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
								<th>Assign To</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
								@forelse ($clients as $client)
								<tr class=
									@if ($client->status=='inactive')
										"red"
									@elseif($client->status=='pending')
										"orange"
									@endif 
									>
									<a href="">
										
										<td>{{ $client->id }}</td>
										<td>{{ $client->fullname }}</td>
										<td>{{ $client->mobile }}</td>
										<td>{{ $client->email }}</td>
										<td>{{ $client->created_at }}</td>
										<td>{!! $client->user_firstname.' '.$client->user_lastname.' ('.$client->user_username.')' !!}</td>
										<td>{{ $client->status }}</td>
										<td>
											<div class="row">
												<div class="col-md-6 col-sm-6 col-xs-6 p-right-5">
													<a href="{{ url('dashboard/enquiry/'.$client->id) }}" class="btn btn-success btn-xs btn-block" >Open</a>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 p-left-5">
													<a data-toggle="modal" data-target=".bs-example-modal-warning" class="btn btn-primary btn-xs btn-block btn-delete-enquiry" data-id="{{$client->id}}" data-status="{{ $client->status }}">Action</a>
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


	<div class="modal fade bs-example-modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h3 class="modal-title" id="myModalLabel2"><i class="fa fa-edit" ></i> Action</h3>
				</div>
				<div class="modal-body">
					<h4>What <b>Action</b> you want to take?</h4>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4">
							<a href="" id="edit_button" class="btn btn-primary btn-block">Edit</a>
						</div>

						<div id="active_button" class="col-md-4 col-sm-4 col-xs-4">
							<form id="active_form" method="POST" action="">
								{{ csrf_field() }}
								<input type="submit" class="btn btn-success btn-block" name="active" value="Active">
							</form>
						</div>

						<form id="delete_form" method="POST" action="">
							{{ method_field('DELETE') }}
							{{ csrf_field() }}
							<div id="inactive_button" class="col-md-4 col-sm-4 col-xs-4">
								<input type="submit" class="btn btn-warning btn-block" name="inactive" value="Inactive">
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<input type="submit" class="btn btn-danger btn-block" name="delete" value="Delete">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	{{-- Datatables --}}
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section('scripts')
	{{-- Datatables --}}
	<script>
		$(document).ready(function() {
			$('#datatable').dataTable({
				"pageLength": 50
			});
		});
	</script>
	{{-- /Datatables --}}

	<script>
		$(document).on('click', '.btn-delete-enquiry', function() {
			var id = $(this).attr('data-id');
			var status = $(this).attr('data-status');
			$('#edit_button').attr('href', "{{ url('dashboard/enquiry') }}/"+id+"/edit");
			$('#active_form').attr('action', "{{ url('dashboard/enquiry') }}/"+id+"/active");
			$('#delete_form').attr('action', "{{ url('dashboard/enquiry') }}/"+id);

			if (status == 'active') {
				$('#active_button').hide();
				$('#inactive_button').show();
			}
			else if(status == 'inactive'){
				$('#inactive_button').hide();
				$('#active_button').show();
			}
		});
	</script>
@endsection