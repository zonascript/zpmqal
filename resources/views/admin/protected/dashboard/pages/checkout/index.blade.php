@extends('admin.protected.dashboard.main')
@section('content')
	<div class="x_panel">
		<div class="x_title">
			<h2>Package Details</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<section class="content invoice">
				<!-- title row -->
				<div class="row">
					<div class="col-xs-12 invoice-header">
						<h1>
							{{ $product }}
							<small class="pull-right">Id: {{ $txnid }}</small>
						</h1>
					</div>
				</div>
				<div class="m-top-20"></div>
				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table">
						<table class="table table-striped">
							<tbody>
								<tr>
									<td>Price</td>
									<td>{{ $price }}</td>
								</tr>
								<tr>
									<td>Validity</td>
									<td>
										{{ $duration }}
									</td>
								</tr>
								<tr>
									<td>Description</td>
									<td>{{ $plan->description }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->

				<div class="row">
					<!-- accepted payments column -->
					<div class="col-xs-6">
						<p class="lead">Payment Methods:</p>
						<img src="images/visa.png" alt="Visa">
						<img src="images/mastercard.png" alt="Mastercard">
						<img src="images/american-express.png" alt="American Express">
						<img src="images/paypal.png" alt="Paypal">
						<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
							Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
						</p>
					</div>
					<!-- /.col -->
					<div class="col-xs-6">
						<p class="lead">Amount Details</p>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									{{-- <tr>
										<th style="width:50%">Wallet Balance:</th>
										<td>2500</td>
									</tr> --}}
									<tr>
										<th style="width:50%">Subtotal:</th>
										<td>{{ $price }}</td>
									</tr>
									<tr>
										<th>Tax (15%)</th>
										<td>{{ $tax }}</td>
									</tr>
									<tr>
										<th>PayUMoney Charge (2.9%):</th>
										<td>{{ $payumoney }}</td>
									</tr>
									<tr>
										<th>Total:</th>
										<td>{{ $total }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->

				<!-- this row will not appear when printing -->
				<div class="row no-print">
					<div class="col-xs-12">
						<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
						<form action="{{url('agent/pay')}}">
							<input type="hidden" name="amount" value="{{ $total }}"/>
							<input type="hidden" name="txnid" value="{{ $txnid }}"/>
							<input type="hidden" name="product" value="{{ $product }}"/>
							<button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
@endsection