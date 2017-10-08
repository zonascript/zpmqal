@extends('traveler.layout.main')

@section('title', 'Hotels')

@section('content')
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="">Home</a></li>
			<li><a href="#">{{ $dest->country }}</a></li>
			<li class="active">{{ $dest->destination }}</li>
		</ul>
		<h3 class="booking-title"></h3>
		@include('traveler.pages.hotel.search.modify_land')	
		
		<div class="row">
			<div class="col-md-3">
				{{-- @include('traveler.pages.hotel.search.modify')	 --}}
				@include('traveler.pages.hotel.search.filter')	
			</div>
			<div class="col-md-9">
				<div class="nav-drop booking-sort">
          <h5 class="booking-sort-title"><a href="#">Sort: Aviability<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
          <ul class="nav-drop-menu">
            <li><a href="#">Price (low to high)</a>
            </li>
            <li><a href="#">Price (hight to low)</a>
            </li>
            <li><a href="#">Ranking</a>
            </li>
            <li><a href="#">Distance</a>
            </li>
            <li><a href="#">Number of Reviews</a>
            </li>
          </ul>
      	</div>
				<ul id="app" class="booking-list">
					@include('traveler.pages.hotel.search.item')
				</ul>
				{{-- @include('traveler.pages.hotel.search.pagination') --}}
			</div>
		</div>
		<div class="gap"></div>
	</div>
@endsection

@section('scripts')
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"></script>
	@include('traveler.pages.index.scripts')
  <script>

    var app = new Vue({
      
      el: '#app',
      
      data: {
         search: '',
         id: '',
         hotels: []
      },
      
      mounted() {
      	var self = this;
      	axios.get('{!! url('api/hotels').'?'.http_build_query(request()->input()) !!}')
			  .then(function (response) {
			    // console.log(response);
		  		self.hotels = response.data.hotels
		  		self.id = response.data.id
		  		self.$nextTick(function(){
			  		initNiceScroll();
		      })
			  })
			  .catch(function (error) {
			    // console.log(error)
			  });
      }      
    })

</script>
@endsection