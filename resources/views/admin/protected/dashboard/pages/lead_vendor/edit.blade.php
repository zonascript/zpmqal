@extends('admin.protected.dashboard.main')

@section('content')
	<div class="row">
    <div class="col-md-2 col-sm-2 col-xs-12">
      <a href="{{ str_replace('/edit', '', \Request::url()) }}" class="btn btn-success btn-block"><i class="fa fa-arrow-left"></i> Back to All Contacts</a>
    </div>
		<div class="col-md-8 col-sm-8 col-xs-12">
			<div class="form-style-8" >
				<h2 class="font-white">Lead Vendor Detail</h2>
				<form method="POST" action="{{ str_replace('/edit', '', \Request::url()) }}" accept-charset="UTF-8" enctype="multipart/form-data">
					{{ method_field('PUT') }}
					{{ csrf_field() }}

					<input type="text" name="company_name" value="{{ $vendor->company_name }}" placeholder="Company Name" />
					<input type="text" name="contact_person" value="{{ $vendor->contact_person }}" placeholder="Contact Person" />
					<input type="text" name="contact_number" value="{{ $vendor->contact_number }}" placeholder="Mobile" maxlength="10"/>
					<input type="text" name="email_id" value="{{ $vendor->email_id }}" placeholder="Email" />
					<input type="text" name="website" value="{{ $vendor->website }}" placeholder="Website">
					<textarea name="address" placeholder="Address" onkeyup="adjust_textarea(this)">{{ $vendor->address }}</textarea>
					<textarea name="note" placeholder="Note: like (This Company provide genuine client.)" onkeyup="adjust_textarea(this)">{{ $vendor->note }}</textarea>

					<label for="file">Any Logo</label>
					<input type="file" class="btn btn-default btn-block" name="logo"/>

					<div class="row padding-tb-10">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="submit" class="btn btn-success btn-block radius-0" value="Save" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
	{{-- Custom Js  --}}
	<script src="{{ asset('js/custom-file-input.js') }}"></script>
@endsection