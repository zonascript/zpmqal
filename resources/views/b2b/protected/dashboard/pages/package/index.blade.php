@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="">
					<div class="col-md-9 col-sm-9 col-xs-12 nopadding">
						<h2>
							{{ $client->fullname }}
							<small>({{ $client->leadVendor->company_name }})</small>
						</h2>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
						<a href="{{ url('dashboard/package/create/'.$client->id.'/') }}" type="button" id="formSubmit" class="btn btn-success btn-block">Build New Package</a>
					</div>
				</div>
				<div class="x_content">
					<div class="col-md-5 col-sm-5 col-xs-12">
						<p>
							<i class="fa fa-phone"> :</i>
							<span>
								{{ isset($client->mobile) ? $client->mobile : '' }}
							</span>
						</p>
						<p>
							<i class="fa fa-envelope"> :</i>
							<span>
								{{ isset($client->email) ? $client->email : '' }}
							</span>
						</p>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<p>
							<label for=""><i class="fa fa-edit"> </i> Note : </label>
							<div class="scroll-bar" style="max-height: 163px; overflow: auto;">
								{{ isset($client->note) ? $client->note : '' }}
							</div>
						</p>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 m-top-10">
						<p>
							<label for=""><i class="fa fa-calendar"> </i> Created At : </label>
							<span>
								{{ isset($client->created_at) ? $client->created_at : '' }}
							</span>
						</p>
						<p>
							<label for=""><i class="fa fa-calendar"> </i> Updated At : </label>
							<span>
								{{ isset($client->updated_at) ? $client->updated_at : '' }}
							</span>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Packages List</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>PackageId</th>
								<th>Opening Date</th>
								<th>Updated Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@forelse ($packages as $package)
								<tr>
									<td>
										{{ getPackageId($package->id) }}
									</td>
									<td>
										{{ $package->created_at }}
									</td>
									<td>
										{{ $package->updated_at }}
									</td>
									<td>{{ $package->status }}</td>
									<td>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-6 p-right-5">
												<a href="{{ urlPackageAll($client->id, $package->id) }}" class="btn btn-success btn-xs btn-block">Open</a>
											</div>	
											<div class="col-md-6 col-sm-6 col-xs-6 p-left-5">
												<button type="button" class="btn btn-danger btn-xs btn-block">Delete</button>
											</div>
										</div>
									</td>
								</tr>
							@empty
							@endforelse
						</tbody>
					</table>
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
@endsection
