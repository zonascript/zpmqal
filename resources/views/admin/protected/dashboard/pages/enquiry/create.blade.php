@extends('admin.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="{{url('dashboard/enquiry')}}" class="btn btn-success btn-block">
				<i class="fa fa-arrow-left"></i> Back To All Enquiry
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-6 col-md-offset-2 col-xs-12">
			<div class="form-style-8 m-top-20" >
				<h2>Detail Plase</h2>
				<form method="post" action="{{url('dashboard/enquiry')}}">
					{{ csrf_field() }}

					<select name="vendor">
						<option value="null">Lead From(Vendor)?</option>
						@foreach ($leadVendors as $leadVendor)
							<option value="{{ $leadVendor->id }}" name="vendor">{{ $leadVendor->company_name }}</option>
						@endforeach
					</select>

					<select name="agent">
						<option value="">Assign To?</option>
						@foreach ($agents as $agent)
							<option value="{{ $agent->id }}" name="agent">
								{{ $agent->firstname.' '.$agent->lastname.' ('.$agent->email.')' }}
							</option>
						@endforeach
					</select>

					<input type="text" name="fullname" placeholder="Full Name" />
					<input type="text" name="mobile" placeholder="Mobile" maxlength="10"/>
					<input type="email" name="email" placeholder="Email" />
					<textarea name="note" placeholder="Message" onkeyup="adjust_textarea(this)"></textarea>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="submit" class="btn btn-success btn-block radius-0" value="Let's Go..." />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
