@if (!is_null($clients) && !empty($clients))
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<h2>Client Status</h2>
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
										<td>{!! $client->user_firstname.' '.$client->user_lastname.' ('.$client->user_email.')' !!}</td>
										<td>{{ $client->status }}</td>
										<td>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<a href="{{ url('dashboard/enquiry/'.$client->id) }}" class="btn btn-success btn-xs btn-block" >Open</a>
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
@endif
