<article class="item">
	<header>
		<h1 class="title">Itinerary</h1>
	</header>
	<div class="content clearfix p-10">
		<div class="x_content sans-serif">
			<ul class="list-unstyled timeline">
				@foreach ($package->itinerary as $itinerary)
					<li class="noborder">
						<div class="block">
							<div class="tags">
								<a href="" class="tag">
									<span>Day {{$itinerary->day}}</span>
								</a>
							</div>
							<div class="block_content">
								<div class="m-top-10"></div>
								@foreach ($itinerary->body as $body)
									@foreach ($body as $key => $value)
										<h2 class="title c-title i-{{$key}}">
											<p class="excerpt sans-serif font-size-14">{!!$value!!}</p>
										</h2>
									@endforeach
								@endforeach
							</div>
						</div>
					</li>
				@endforeach
			</ul>

		</div>
	</div>
</article>

