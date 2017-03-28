@extends('b2b.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-md-offset-2 col-xs-12">
			<div class="vertical-center">
				<div class="form-style-8" >
					<h2>Detail Plase</h2>
					<form method="post" action="{{url('dashboard/enquiry')}}">
						{{ csrf_field() }}

						<select name="vendor">
							<option value="">Lead From(Vendor)?</option>
							@foreach ($leadVendors as $leadVendor)
								<option value="{{ $leadVendor->id }}" name="vendor">{{ $leadVendor->company_name }}</option>
							@endforeach
						</select>

						<input type="text" name="fullname" placeholder="Full Name" />
						<input type="text" name="mobile" placeholder="Mobile" maxlength="10"/>
						<input type="email" name="email" placeholder="Email" />
						{{-- <textarea name="note" placeholder="Message" onkeyup="adjust_textarea(this)"></textarea> --}}
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="submit" class="btn btn-success btn-block radius-0" value="Let's Go..." />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
