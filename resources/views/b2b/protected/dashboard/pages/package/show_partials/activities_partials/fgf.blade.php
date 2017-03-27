<?php
	$activityImageThumb = ifset($fgfActivity->Images[0], urlDefaultImageActivity());
	$activityName = ifset($fgfActivity->ActivityName);
	$activityDescription = ifset($fgfActivity->Description);
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
						<span id="activitySortDescription_{{ $selectedActivity->index }}">
							{!! sub_string($activityDescription, 450) !!}
						</span>

						@if (strlen($activityDescription) != '')
							<button id="btn-descriptionMore_{{ $selectedActivity->index }}" 
								class="btn-link cursor-pointer nopadding" 
								data-toggle="modal" data-target=".bs-example-modal-lg" 
								data-title="{{ $activityName }} : Description" data-bodyid="activityFullDescription_{{ $selectedActivity->index }}" 
								data-button="false" data-Index="{{ $selectedActivity->index }}">More
							</button>
						@endif
						<div id="activityFullDescription_{{ $selectedActivity->index }}" hidden>
							{!! $activityDescription !!}
						</div>
					</div>
				</div>
			</div>

			{{-- <div class="col-md-2 col-sm-2 col-xs-12">
				<div class="height-150px vertical-parent">
					<div class="vertical-child">
						<div>
							<h2>
								<span>{{ ifset($ActivityResult->currency) }}</span> 
								<span>{{ ifset($ActivityResult->finalPrice) }}</span>
							</h2> 
						</div>
					</div>
				</div>
			</div> --}}
			
		</div>
	</div>
</li>