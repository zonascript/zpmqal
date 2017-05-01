
	{{-- Clock --}}
	{{-- 	<script>
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
				if (i < 10) {i = "0" + i};
				return i;
		}
	</script> --}}
	{{-- Clock --}}

	{{-- Chart.js --}}
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
	{{-- /Chart.js --}}