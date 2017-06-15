<!DOCTYPE html>
<html lang="en">
	<head>
		@include('common.protected.dashboard.partials._head')
	</head>
	<body class="nav-md" {{ isset($other->onload) ? $other->onload : '' }}>
		@yield('beforecontent')
		
		<div class="container body">
			<div class="main_container">
				{{-- Navigation --}}
				@yield('_nav_left')

				@yield('_nav_top')
				
				{{-- @include('common.protected.dashboard.partials._nav_top') --}}
				
				<div class="right_col" role="main">
					{{-- Errors Content --}}
					<div class="row">
						{{-- Success message shows here --}}
						@if (Session::has('success'))
							<div class="alert alert-success">
								<ul>
									<li>{{ Session::get('success') }}</li>
								</ul>
							</div>
						@endif

						@if (Session::has('warning'))
							<div class="alert alert-warning">
								<ul>
									<li>{{ Session::get('warning') }}</li>
								</ul>
							</div>
						@endif

						{{-- Errors message shows here --}}
						@if (count($errors) > 0 || Session::has('danger'))
							<div class="alert alert-danger">
								<ul>
									<li>{{ Session::get('danger') }}</li>
									
									@forelse ($errors->all() as $error)
										<li>{{ $error }}</li>
									@empty

									@endforelse
								</ul>
							</div>
						@endif

					</div>
					
					{{-- Main content --}}
					@yield('content')

				</div>

				{{-- Footer --}}
				@include('common.protected.dashboard.partials._footer')
			</div>
		</div>
		@yield('aftercontent')
		@include('common.protected.dashboard.partials._scripts')
	</body>
</html>
