@extends('admin.protected.dashboard.main')

@section('css')
	<link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css">
	<link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">
@endsection

@section('content')
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-12">
						<h2>Add Activity</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-8 form-group has-feedback">
							<input type="hidden" id="act_id" value="{{ $activity->id }}">

							<input type="text" id="title" class="form-control" placeholder="Title" value="{{ $activity->title }}" required />
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
							<input type="text" id="destination" data-code="{{ $activity->destination_code }}" class="form-control destination" placeholder="Title" value="{{ isset($activity->destination->location) ? $activity->destination->location : '' }}" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-8 form-group has-feedback">
							<textarea id="description" placeholder="text">{{ $activity->description }}</textarea>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
							<form id="uploadform" class="uploadform dropzone no-margin nopadding dz-clickable text-left min-max-height-320px bg-color-gray" data-path="" data-host="">	
								{{ csrf_field() }}
								<div class="dz-default dz-message">
									<div class="row">
										<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
											<div class="height-100px vertical-parent">
												<div class="vertical-child">
													Drop activity image here
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="padding-tb-10">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<button class="btn btn-success btn-block btn-save">Save</button>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<a href="{{ url('dashboard/inventories/activity') }}" class="btn btn-primary btn-block btn-save">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('headJs')
	<script src="{{ asset('js/tinymce.min.js') }}"></script>
	<script>
		tinymce.init({ 
			selector:'textarea',
			plugins : 'autolink link image lists preview table',
			menu: {
				file: {title: 'File', items: 'newdocument'},
				edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
				insert: {title: 'Insert', items: 'link media | template hr'},
				view: {title: 'View', items: 'visualaid'},
				format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
				table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
				tools: {title: 'Tools', items: 'spellchecker code'}
			},
			menubar: 'file edit insert view format table tools',
			height : 210
		});
	</script>
@endsection

@section('js')
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
	<script src="{{ asset('js/mydropzone.js') }}"></script>
@endsection


@section('scripts')
	<script>
		$(document).ready(function(argument) {
			addDropzone('#uploadform', '{{ url('api/image/upload') }}');
		});

		$(document).on('keyup paste', '.destination', function(){
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

		$(document).on('click', '.btn-save', function (argument) {
			var id = $('#act_id').val();
			var title = $('#title').val();
			$('.x_panel').find('.border-red').removeClass('border-red');
			
			if (title == '') { 
				$('#title').addClass('border-red');
				return false;
			}

			var destCode = $('#destination').attr('data-code');
			if (destCode == '') {
				$('#destination').addClass('border-red');
				$.alert({
					'title' : 'Alert ?',
					'content' : 'select destination first'
				});
				return false;
			}

			var images = makeImagesObject();
			var desc = tinymce.get('description').getContent();
			var data = {
					'id' : id,
					'title'	: title,
					'format' : 'json',
					'images' : images,
					'description'	: desc,
					'_token' : csrf_token,
					'dest_code'	: destCode,
				};

			console.log(data);

			$.ajax({
				url : "{{ url('dashboard/inventories/activity/store') }}",
				type : "post",
				data : data,
				dataType : "JSON",
				success : function () {
					document.location.href = "{{ url('dashboard/inventories/activity') }}";
				} 
			});
		});
	</script>
@endsection
