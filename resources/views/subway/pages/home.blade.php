<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		@include('subway.pages.partials.head')
	</head>
	<body id="page" class="page home blog sidebar-a-right sidebar-b-right isblog wp-home wp-front_page transparency-75 system-transparent">
		<div id="page-body">
			<div class="page-body-1">
				<div id="socialbar">
					@include('subway.pages.partials.social')
				</div>
				<div class="wrapper grid-block">
					@include('subway.pages.partials.header')
					<div class="row">
						<div class="col-md-7 col-sm-7 col-xs-12">
							<section id="content" class="grid-block">
								<div id="system">
									<div class="items items-col-1 grid-block">
										<div class="grid-box width100">
											@include('subway.pages.partials.routes')	
											@include('subway.pages.partials.flights')	
											@include('subway.pages.partials.accomo')	
											@include('subway.pages.partials.activities')	
										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-12 subway-theme-font">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									@include('subway.pages.partials.pricing')
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									@include('subway.pages.partials.agent')
								</div>
							</div>
							<div class="row font-size-0" style="color:transparent;">
								@include('subway.pages.partials.slideshow')
							</div>
						</div>
					</div>
					{{-- @include('subway.pages.partials.footer') --}}
				</div>
				<script type='text/javascript' src='{{ url('/') }}/subway/wp-includes/js/wp-embed.min1c9b.js?ver=4.6.1'></script>
			</div>
		</div>
	</body>
</html>