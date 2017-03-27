

<script>
	var _token = $('[name="csrf_token"]').attr('content');

	var flights = new Vue({
		el: "#flights_result",
		data: { 
			message: 'Hello Vue World',
			qpxFlights: [],
			tripOptions : [],
			token: _token,
			error: '',
			cities:{},
			carrier:{},
			search : ''
		},
		watch : {
			filterSearch : function () {
				if (this.search.length > 0) {
					alert(this.search)
					this.filteredItems()
				}
			}
		},
		created() {
	    this.postQpxFlights()
	  },
		methods:{
			filteredItems() {
				console.log(this.search)
				var targetList = $('#tab_menu').find('.active').attr('data-list')
				@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
					if (targetList == "fligth_{{ $flightRoute->id }}") {
						console.log(this.fligth_{{ $flightRoute->id }})
						return this.fligth_{{ $flightRoute->id }}.search(this.search)

					}
				@endforeach
	    },

			postQpxFlights : function() {
				thisData = this
				axios.post('{{ url('qpx/flights/result/72') }}', {
				    _token: thisData.token,
				  })
				  .then(function (response) {
				  	thisData.qpxFlights = response.data
				  	thisData.tripOptions = response.data.trips.tripOption
				  	thisData.setCarrier(response.data.trips.data.carrier)
				  })
				  .catch(function (error) {
				  	thisData.error = error
				  })
			},

			imageUrl : function (code) {
				return "{{ urlImage('images/airlineImages/') }}"+code+".gif"
			},

			setCitiesAndCarrier : function () {
				tempCities = this.qpxFlights.trips.data.carrier
				for (var i = 0; i <= arr.length; i++) {
					this.$set(this.cities, tempCities[i].code, tempCities[i].name)
				}

				tempCarrier = this.qpxFlights.trips.data.city
				for (var i = 0; i <= tempCarrier.length; i++) {
					this.$set(this.carrier, tempCarrier[i].code, tempCarrier[i].name)
				}
			},
			setCities : function (tempCities) {
				for (var i = 0; i <= arr.length; i++) {
					this.$set(this.cities, tempCities[i].code, tempCities[i].name)
				}
			},
			setCarrier : function (tempCarrier) {
				for (var i = 0; i <= tempCarrier.length; i++) {
					this.$set(this.carrier, tempCarrier[i].code, tempCarrier[i].name)
				}
				this.setCitiesAndCarrier()
			},
			getDate : function (datetime) {
				return moment(datetime).format("DD-MM-YYYY")
			},
			getTime : function (datetime) {
				return moment(datetime).format("HH:mm")
			}
		},
		mounted: function () {
			this.$nextTick(function () {
				var options = { valueNames: ['search-word'] };

				@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
					this.$set(fligth_{{ $flightRoute->id }}, List("fligth_{{ $flightRoute->id }}", options));
				@endforeach

				// @foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
				//	var fligth_{{ $flightRoute->id }} = new List("fligth_{{ $flightRoute->id }}", options);
				// @endforeach

				// $(document).on('keypress keyup keydown', "#filter_search", function(){
				// 		var targetList = $('#tab_menu').find('.active').attr('data-list');
				// 		var search = $(this).val();
				// 		@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
				// 			if (targetList == "fligth_{{ $flightRoute->id }}") {
				// 				fligth_{{ $flightRoute->id }}.search(search);
				// 			}
				// 		@endforeach
				// });
		  });
		}
	});



</script>
{{-- filter List.js--}}
<script>

	// flights.$nextTick(function () {
	// 	var options = { valueNames: ['search-word'] };

	// 	@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
	// 		var fligth_{{ $flightRoute->id }} = new List("fligth_{{ $flightRoute->id }}", options);
	// 	@endforeach


	// 	$(document).on('keypress keyup keydown', "#filter_search", function(){
	// 			var targetList = $('#tab_menu').find('.active').attr('data-list');
	// 			var search = $(this).val();
	// 			@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
	// 				if (targetList == "fligth_{{ $flightRoute->id }}") {
	// 					fligth_{{ $flightRoute->id }}.search(search);
	// 				}
	// 			@endforeach
	// 	});
 //  });

	// $(document).on('keypress keyup keydown', "#filter_search", function(){
	// 	var options = { valueNames: ['search-word'] };

	// 	@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
	// 		var fligth_{{ $flightRoute->id }} = new List("fligth_{{ $flightRoute->id }}", options);
	// 	@endforeach

	// 	var targetList = $('#tab_menu').find('.active').attr('data-list');
	// 	var search = $('#filter_search').val();
	// 	@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
	// 		if (targetList == "fligth_{{ $flightRoute->id }}") {
	// 			fligth_{{ $flightRoute->id }}.search(search);
	// 		}
	// 	@endforeach
	// });
  
  $(document).on('keypress keyup keydown', "#filter_search", function(){
		flights.filteredItems();
	});
</script>
{{-- /filter List.js --}}