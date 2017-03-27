<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_content" >
			<div class="gallery cf">
				@foreach ($ssImages as $ssImage)
					<div class="height-160px width-48-p">
						<img class="width-100-p height-100p" src="{{ $ssImage }}" />
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>