@extends('admin.protected.dashboard.main')

@section('css')
	<link href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Activities</h2>
					<a href="{{ url('dashboard/inventories/activity/create') }}" class="btn btn-success pull-right">Add Activity</a>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>Title</th>
								<th>Destination</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($activities as $activity)
								<tr>
									<td>{{ $activity->id }}</td>
									<td>{{ $activity->title }}</td>
									<td>{{ $activity->destination->location }}</td>
									<td class="{{ statusCss($activity->is_active) }}">{{ $activity->status->name }}</td>
									<td>
										<div class="row">
											<div class="btn-group pull-right m-right-10">
												<a href="{{ $activity->openUrl() }}" class="btn btn-default btn-success">Open</a>
												<div class="btn-group">
													<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false"> More <span class="caret"></span> </button>
													<ul class="dropdown-menu">
														<li>
															<a href="{{ url('dashboard/inventories/activity/store/'.$activity->id) }}">Edit</a>
														</li>
														@if ($activity->is_active == 1)
															<li>
																<a class="trigger-form">Deactivate</a>
																<form method="POST" action="{{ $activity->openUrl().'/deactivate' }}">
																	{{ csrf_field() }}
																	{{ method_field('put') }}
																	<button type="submit" class="input-submit" hidden></button>
																</form>
															</li>
														@endif
														@if (in_array($activity->is_active,[0, 2]))
															<li>
																<a class="trigger-form">Activate</a>
																<form method="POST" action="{{ $activity->openUrl().'/activate' }}">
																	{{ csrf_field() }}
																	{{ method_field('put') }}
																	<button type="submit" class="input-submit" hidden></button>
																</form>
															</li>
														@endif
														<li>
															<a class="user-delete" data-href="{{ $activity->openUrl() }}">Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row">
						<span class="pull-right">
							{{ $activities->appends(request()->input())->links() }}
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form action="" id="dest_form" hidden>
		<input type="hidden" name="city" value="">
	</form>


@endsection

@section('js')
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/mydatatable.js') }}"></script>
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			datatableWithSearch('#datatable', {}, '', 'Destination: <input type="text" data-code="" class="form-control location input-sm m-right-10" placeholder="">');
		});


		{{-- for more button --}}
		$(document).on('click', '.user-delete', function () {
			var url = $(this).attr('data-href');
			$.confirm({
				title: 'Are you sure?',
				content: 'If you delete activity you will never be able recover deleted data. <form action="'+url+'" method="post" class="hide">{{ csrf_field() }} {{ method_field('delete') }}<button type="Submit" id="btn_delete"><button></form>',
				buttons: {
					cancel: function () {
						//close
					},
					formSubmit: {
						text: 'Submit',
						btnClass: 'btn-blue',
						action: function () {
							$('#btn_delete').trigger('click');
						}
					}
				}
			});
		});

		$(document).on('click', '.trigger-form', function () {
			$(this).closest('li').find('.input-submit').trigger('click');
		});
		{{-- /for more button --}}


		$(document).on('keyup paste', '.location', function(){
			$(this).autocomplete({
				minLength: 0,
				source: "{{ route("destination.names") }}",
				focus: function( event, ui ) {
					$(this).val( ui.item.name );
					return false;
				},
				select: function( event, ui ) {
					$(this).val( ui.item.name );
					$(this).attr('data-code', ui.item.code);
					$('[name="city"]').val(ui.item.code);
					var serachSorm = $('#dest_form');
					serachSorm.submit();
					return false;
				}
			})
			.autocomplete()
			.data("ui-autocomplete")._renderItem =  function( ul, item ) {
				 return $( "<li>" )
				 .append( "<a>" + item.name+"</a>" )
				 .appendTo( ul );
			 };
		});
	</script>
@endsection