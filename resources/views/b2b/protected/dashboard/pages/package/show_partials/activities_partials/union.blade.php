<?php
	$activityName = $unionActivity->name;
	$activityImageThumb = $unionActivity->image;
	$activityDescription = $unionActivity->description;
?>

<li class="min-height-110px">
	<div class="m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="row height-165px">
						<img src="{{ $activityImageThumb }}" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2>{{ $activityName }}</h2>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<span id="activitySortDescription_{{ $unionActivityKey }}">
							{!! sub_string($activityDescription, 450) !!}
						</span>

						@if (strlen($activityDescription) != '')
							<button id="btn-descriptionMore_{{ $unionActivityKey }}" 
								class="btn-link cursor-pointer nopadding btn-model" 
								data-toggle="modal" data-target=".bs-example-modal-lg" 
								data-title="{{ $activityName }} : Description" data-bodyid="activityFullDescription_{{ $unionActivityKey }}" 
								data-button="false" data-Index="{{ $unionActivityKey }}">More
							</button>
						@endif
						<div id="activityFullDescription_{{ $unionActivityKey }}" hidden>
							{!! $activityDescription !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>