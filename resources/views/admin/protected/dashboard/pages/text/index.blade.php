@extends('admin.protected.dashboard.main')

@section('content')
	<div class="">

		<div class="page-title">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/settings/text/create') }}" class="btn btn-success btn-block">Add Text</a>
				</div>
				<div class="col-md-4 col-sm-7 col-xs-12 text-center">
					<h3>Texts</h3>
				</div>
				<div class="col-md-5 col-sm-8 col-xs-12 form-group pull-right top_search">
					<form action="{{ url('dashboard/settings/text') }}" method="head">
						<div class="input-group">
								<input type="text" class="form-control" name="t" placeholder="Search for...">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit">Go!</button>
								</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			@forelse($texts as $text)
				<div class="col-md-12 col-sm-12 col-xs-12 ">
					<div class="x_panel {{ $text->status=='inactive' ? 'border-red' : '' }}">
						<div class="x_title">
							<h2>{{ $text->title }}</h2>
							<ul class="nav navbar-right panel_toolbox panel_toolbox1">
								<li></li>
								<li></li>
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content" {!! $text->status=='inactive' ? 'style="display: none;"' : '' !!}>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="max-height-350px scroll-auto scroll-bar">
										{!! sub_string(strip_tags($text->text), 500) !!}
									</div>
								</div>
							</div>
							<div class="row m-top-10">
								<div class="col-md-2 col-sm-2 col-xs-12">
									<a href="{{ url('dashboard/settings/text/'.$text->id) }}" class="btn btn-success btn-block">Open</a>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<button data-toggle="modal" data-target=".bs-example-modal-warning"  class="btn btn-primary btn-block btn-delete-text" data-id="{{$text->id}}" data-status="{{ $text->status }}">Action</button>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-12 text-right">
									<div class="m-top-20">
										<b>Status : </b>(<span class="{{ $text->status=='inactive' ? 'red' : '' }}">{{ proper($text->status) }}</span>)
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@empty
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						You have not added any text.
					</div>
				</div>
			@endforelse
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

@section('scripts')
	<script>
		$(document).on('click', '.btn-delete-text', function() {
			var id = $(this).attr('data-id');
			var status = $(this).attr('data-status');

			$('#edit_button').attr('href', "{{ url('dashboard/settings/text') }}/"+id+"/edit");
			$('#active_form').attr('action', "{{ url('dashboard/settings/text') }}/"+id+"/active");
			$('#delete_form').attr('action', "{{ url('dashboard/settings/text') }}/"+id);

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
