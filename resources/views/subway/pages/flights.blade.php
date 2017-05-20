<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		@include('subway.pages.home_partials.head')
	</head>
	<body id="page" class="page home blog sidebar-a-right sidebar-b-right isblog wp-home wp-front_page transparency-75 system-transparent">
		<div id="page-body">
			<div class="page-body-1">
				<div id="socialbar">
					@include('subway.pages.home_partials.social')
				</div>
				<div class="wrapper grid-block">
					@include('subway.pages.home_partials.header')
					<div class="row">
						<div class="col-md-7 col-sm-7 col-xs-12">
							<section id="content" class="grid-block">
								<div id="system">
									<div class="items items-col-1 grid-block">
										<div class="grid-box width100">
											@include('subway.pages.flights_partials.flights')	
										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-12 subway-theme-font">
							<div class="m-top-5">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448183.73907005717!2d76.81307299667618!3d28.646677259922765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1495309165394" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
					{{-- @include('subway.pages.home_partials.footer') --}}
				</div>
				<script type='text/javascript' src='{{ url('/') }}/subway/wp-includes/js/wp-embed.min1c9b.js?ver=4.6.1'></script>
			</div>
		</div>
	</body>
</html>