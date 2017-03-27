@extends('admin.protected.dashboard.main')

@section('content')
	<div class="">

		<div class="page-title">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/settings/text') }}" class="btn btn-success btn-block"><i class="fa fa-arrow-left"></i> Back to Texts</a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			@if (!is_null($text))
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>{{ $text->title }}</h2>
							<ul class="nav navbar-right panel_toolbox panel_toolbox1">
								<li></li>
								<li></li>
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content" >
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									{!! $text->text !!}
								</div>
							</div>
							<div class="row m-top-10">
								<div class="col-md-2 col-sm-2 col-xs-12">
									<a href="{{ url('dashboard/settings/text/'.$text->id.'/edit') }}" class="btn btn-success btn-block">Edit</a>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<button data-toggle="modal" data-target=".bs-example-modal-warning"  class="btn btn-primary btn-block btn-delete-text" data-id="{{$text->id}}" data-status="{{ $text->status }}">Action</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			@else
				<p>Sorry... there is no vendor</p>
			@endif
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

						@if ($text->status != 'active')
							<div id="active_button" class="col-md-6 col-sm-6 col-xs-6">
								<form id="active_form" method="POST" action="{{url('dashboard/settings/text/'.$text->id.'/active')}}">
									{{ csrf_field() }}
									<input type="submit" class="btn btn-success btn-block" name="active" value="Active">
								</form>
							</div>
						@endif

						<form id="delete_form" method="POST" action="{{url('dashboard/settings/text/'.$text->id)}}">
							{{ method_field('DELETE') }}
							{{ csrf_field() }}
							@if ($text->status != 'inactive')
								<div id="inactive_button" class="col-md-6 col-sm-6 col-xs-6">
									<input type="submit" class="btn btn-warning btn-block" name="inactive" value="Inactive">
								</div>
							@endif
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="submit" class="btn btn-danger btn-block" name="delete" value="Delete">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection