@extends('backend.protected.dashboard.main')
@section('content')
	<div class="row top_tiles">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="tile-stats">
						<a href="{{ url('dashboard/activities/create') }}">
							<div class="height-200px font-size-30 vertical-parent">
								<div class="vertical-child">
									<i class="fa fa-futbol-o font-size-80"></i>
									<div>New Activity</div>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="tile-stats">
						<a href="{{ url('dashboard/activities') }}">
							<div class="height-200px font-size-30 vertical-parent">
								<div class="vertical-child">
									<i class="fa fa-list font-size-80"></i>
									<div>Activities List</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	{{-- bootstrap-progressbar --}}
	<script src="{{ commonAsset('dashboard/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
	{{-- Chart.js --}}
	<script src="{{ commonAsset('dashboard/vendors/Chart.js/dist/Chart.min.js') }}"></script>
	{{-- ECharts --}}
	<script src="{{ commonAsset('dashboard/vendors/echarts/dist/echarts.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/echarts/map/js/world.js') }}"></script>
@endsection

@section('scripts')
	{{-- Clock --}}
	<script>
		function startTime() {
				var today = new Date();
				var h = today.getHours();
				var m = today.getMinutes();
				var s = today.getSeconds();
				m = checkTime(m);
				s = checkTime(s);
				document.getElementById('clock-div').innerHTML =
				h + ":" + m + ":" + s;
				var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
				if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
				return i;
		}
	</script>
	{{-- Clock --}}

	{{-- Chart.js --}}
	<script>
		Chart.defaults.global.legend = {
			enabled: false
		};

		// Line chart
		var ctx = document.getElementById("lineChart");
		var lineChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: ["January", "February", "March", "April", "May", "June", "July"],
				datasets: [{
					label: "My First dataset",
					backgroundColor: "rgba(38, 185, 154, 0.31)",
					borderColor: "rgba(38, 185, 154, 0.7)",
					pointBorderColor: "rgba(38, 185, 154, 0.7)",
					pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(220,220,220,1)",
					pointBorderWidth: 1,
					data: [31, 74, 6, 39, 20, 85, 99]
				}, {
					label: "My Second dataset",
					backgroundColor: "rgba(3, 88, 106, 0.3)",
					borderColor: "rgba(3, 88, 106, 0.70)",
					pointBorderColor: "rgba(3, 88, 106, 0.70)",
					pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(151,187,205,1)",
					pointBorderWidth: 1,
					data: [82, 23, 66, 9, 99, 4, 2]
				}, {
					label: "My Second dataset",
					backgroundColor: "rgba(3, 88, 106, 0.3)",
					borderColor: "rgba(3, 88, 106, 0.70)",
					pointBorderColor: "rgba(3, 88, 106, 0.70)",
					pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(151,187,205,1)",
					pointBorderWidth: 1,
					data: [48, 23, 33, 9, 29, 4, 2]
				}]
			},
		});


		// Bar chart
		var ctx = document.getElementById("mybarChart");
		var mybarChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["January", "February", "March", "April", "May", "June", "July"],
				datasets: [{
					label: '# of Votes',
					backgroundColor: "#26B99A",
					data: [51, 30, 40, 28, 92, 50, 45]
				}, {
					label: '# of Votes',
					backgroundColor: "#03586A",
					data: [41, 56, 25, 48, 72, 34, 12]
				}]
			},

			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>
	{{-- /Chart.js --}}
@endsection