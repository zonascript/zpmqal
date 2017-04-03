<?php
	$activityName = $selectedActivity->detail->name;
	$activityImageThumb = $selectedActivity->detail->image;
	$activityDescription = $selectedActivity->detail->description;
	$uniqueCode = $selectedActivity->detail->code.'_'
							. $selectedActivity->detail->vendor;
?>

<li class="min-height-110px">
	<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="row">
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
							<span id="activitySortDescription_{{ $uniqueCode }}">
								{!! sub_string($activityDescription, 450) !!}
							</span>

							@if (strlen($activityDescription) != '')
								<button id="btn-descriptionMore_{{ $uniqueCode }}" 
									class="btn-link cursor-pointer nopadding btn-model" 
									data-toggle="modal" data-target=".bs-example-modal-lg" 
									data-title="{{ $activityName }} : Description" data-bodyid="activityFullDescription_{{ $uniqueCode }}" 
									data-button="false" data-Index="{{ $uniqueCode }}">More
								</button>
							@endif
							<div id="activityFullDescription_{{ $uniqueCode }}" hidden>
								{!! $activityDescription !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>