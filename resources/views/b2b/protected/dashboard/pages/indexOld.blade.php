@extends('b2b.protected.dashboard.main')
@section('content')
		<!-- top tiles -->
		<div class="row tile_count">
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
				<span class="count_top"><i class="fa fa-user"></i> Total Leads</span>
				<div class="count">2500</div>
				<span class="count_bottom"><i class="green">4% </i> From last Week</span>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
				<span class="count_top"><i class="fa fa-user"></i> Yesterday's Leads </span>
				<div class="count blue">50</div>
				<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
				<span class="count_top"><i class="fa fa-user"></i> Today's Attended Leads</span>
				<div class="count green">50</div>
				<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
				<span class="count_top"><i class="fa fa-user"></i> Leads to be Attend</span>
				<div class="count red">50</div>
				<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
				<span class="count_top"><i class="fa fa-user"></i> Total Follow-Up</span>
				<div class="count orange">15</div>
				<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
				<span class="count_top"><i class="fa fa-clock-o"></i> Time Left</span>
				<div class="count" id="clock-div"></div>
				<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
			</div>
		</div>
		<!-- /top tiles -->
		<div class="row top_tiles">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<div class="row">
					<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<a href="{{ url('dashboard/enquiry/create') }}">
								<div class="height-200px font-size-30 vertical-parent">
									<div class="vertical-child">
										<i class="glyphicon glyphicon-user font-size-80"></i>
										<div>New Enquiry</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<a href="{{ url('dashboard/enquiry') }}">
								<div class="height-200px font-size-30 vertical-parent">
									<div class="vertical-child">
										<i class="fa fa-group font-size-80"></i>
										<div>Client List</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<a href="{{ url('dashboard/follow-up') }}">
								<div class="height-200px font-size-30 vertical-parent">
									<div class="vertical-child">
										<i class="fa fa-check-square-o font-size-80"></i>
										<div>Follow-Up</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<a href="{{ url('dashboard/tools') }}">
								<div class="height-200px font-size-30 vertical-parent">
									<div class="vertical-child">
										<i class="fa fa-cogs font-size-80"></i>
										<div>Tools</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<h2>Total Action on Lead</h2>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<select name="" id="" class="m-top-5 width-120">
									@for($m = 1 ; $m <= 12; $m++)
										<option value="{{ $m }}">{{ date("F",strtotime(date("Y")."-".$m."-01")) }}</option>
									@endfor
								</select>
								<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
									<li></li>
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
								</ul>
							</div>
							<div id="lineChartLabels" hidden>["January", "February", "March", "April", "May", "June", "July"]</div>
							<div id="lineChartActive" hidden>[31, 74, 6, 39, 20, 85, 99]</div>
							<div id="lineChartInactive" hidden>[82, 23, 66, 9, 99, 4, 2]</div>
							<div id="lineChartConfirmed" hidden>[48, 23, 33, 9, 29, 4, 2]</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<div class="x_content height-355px ">
						<canvas id="lineChart" class="m-top-30"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Leads Vendor Graph</h2>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<canvas id="mybarChart"></canvas>
					</div>
				</div>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="x_panel tile">
					<div class="x_title">
						<h2>Currency Exchange<small>(INR)</small></h2>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content" style="height:348px;">
						{{-- {{ pre_echo($currencyData) }} --}}
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>INR Default</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%;">
									</div>
								</div>
							</div>
							<div class="w_right w_20">
								<span>1</span>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="widget_summary">
							<div class="w_left w_25">
								<span>USD</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->USD) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->USD) }}%;">
									</div>
								</div>
							</div>
							<div class="w_right w_20">
								<span>{{ roundUp(ifset($currencyData->currencies->USD)) }}</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>SGD</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->SGD) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->SGD) }}%;">
									</div>
								</div>
							</div>
							<div class="w_right w_20">
								<span>{{ roundUp(ifset($currencyData->currencies->SGD)) }}</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>EUR</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->EUR) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->EUR) }}%;">
									</div>
								</div>
							</div>
							<div class="w_right w_20">
								<span>{{ roundUp(ifset($currencyData->currencies->EUR)) }}</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>AED</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->AED) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->AED) }}%;">
									</div>
								</div>
							</div>
							<div class="w_right w_20">
								<span>{{ roundUp(ifset($currencyData->currencies->AED)) }}</span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>IDR</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->IDR) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->IDR) }}%;">
									</div>
								</div>
							</div>
							<div class="w_right w_20">
								<span><small>{{ ifset($currencyData->currencies->IDR) }}</small></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- Start to do list -->
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>To Do List</h2>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li></li>
							<li>
								<a class="">
									<i class="fa fa-plus-square" data-toggle="modal" data-target=".bs-example-modal-to-do"></i>
								</a>
							</li>
							
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content pre-scrollable scroll-bar" >
						<div style="height:338px;">
							<ul id="todo" class="to_do">
								@foreach ($toDos as $toDoKey => $toDo)
									<li>
									<label class="{{ $toDo->status == 'Inactive' ? 'line-through' : '' }}">
										<input type="checkbox" class="h-w-17 checkbox_to_do" {{ $toDo->status == 'Inactive' ? 'checked' : '' }} value="{{ $toDo->id }}" data-checked="{{ $toDo->status == 'Inactive' ? '1' : '0' }}"> {{ $toDo->text }}</label>
									</li>
								@endforeach

							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- End to do list -->

			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Travel Feeds</h2>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content pre-scrollable scroll-bar" >
						<div class="dashboard-widget-content">

							<ul class="list-unstyled timeline widget">
								@foreach ($travelFeeds->channel->item as $travelFeed)
									<li>
										<div class="block">
											<div class="block_content">
												<h2 class="title">
													<a>{{ $travelFeed->title }}</a>
												</h2>
												<p class="excerpt">
													{{ $travelFeed->description }}.. 
													<a href="{{ $travelFeed->link }}" class="btn-link" target="_blank">More</a>
												</p>
											</div>
										</div>
									</li>
								@endforeach

								<li>
									<div class="block">
										<div class="block_content">
											<h2 class="title">
																				<a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
																		</h2>
											<div class="byline">
												<span>13 hours ago</span> by <a>Jane Smith</a>
											</div>
											<p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
											</p>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
@endsection

@section('js')
	<!-- bootstrap-progressbar -->
	<script src="{{ commonAsset('dashboard/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
	<!-- Chart.js -->
	<script src="{{ commonAsset('dashboard/vendors/Chart.js/dist/Chart.min.js') }}"></script>
	<!-- ECharts -->
	<script src="{{ commonAsset('dashboard/vendors/echarts/dist/echarts.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/echarts/map/js/world.js') }}"></script>
@endsection

@section('scripts')
	<!-- Clock -->
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
	<!-- Clock -->

	<!-- Chart.js -->
	<script>

		$(document).ready(function () {
			Chart.defaults.global.legend = {
				enabled: false
			};
			
			lineChart();
			mybarChart();
		});

		
		function lineChart() {
			var labelArray = JSON.parse($('#lineChartLabels').text());
			var ActiveArray = JSON.parse($('#lineChartActive').text());
			var InactiveArray = JSON.parse($('#lineChartInactive').text());
			var ConfirmedArray = JSON.parse($('#lineChartConfirmed').text());

			// Line chart
			var ctx = document.getElementById("lineChart");
			var lineChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labelArray,
					datasets: [{
						label: "My First dataset",
						backgroundColor: "rgba(38, 185, 154, 0.31)",
						borderColor: "rgba(38, 185, 154, 0.7)",
						pointBorderColor: "rgba(38, 185, 154, 0.7)",
						pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
						pointHoverBackgroundColor: "#fff",
						pointHoverBorderColor: "rgba(220,220,220,1)",
						pointBorderWidth: 1,
						data: ActiveArray
					}, {
						label: "My Second dataset",
						backgroundColor: "rgba(3, 88, 106, 0.3)",
						borderColor: "rgba(3, 88, 106, 0.70)",
						pointBorderColor: "rgba(3, 88, 106, 0.70)",
						pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
						pointHoverBackgroundColor: "#fff",
						pointHoverBorderColor: "rgba(151,187,205,1)",
						pointBorderWidth: 1,
						data: InactiveArray
					}, {
						label: "My Second dataset",
						backgroundColor: "rgba(3, 88, 106, 0.3)",
						borderColor: "rgba(3, 88, 106, 0.70)",
						pointBorderColor: "rgba(3, 88, 106, 0.70)",
						pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
						pointHoverBackgroundColor: "#fff",
						pointHoverBorderColor: "rgba(151,187,205,1)",
						pointBorderWidth: 1,
						data: ConfirmedArray
					}]
				},
			});
		}

		function mybarChart() {
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
		}
	</script>
	<!-- /Chart.js -->
@endsection