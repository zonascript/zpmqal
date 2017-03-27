<?php
	$activityImageThumb = ifset($viatorActivity->thumbnailURL, urlDefaultImageActivity());
	$activityName = ifset($viatorActivity->shortTitle);
	$activityDuration = ifset($viatorActivity->duration);
	$activityDescription = ifset($viatorActivity->shortDescription);
?>

<div class="box-stack min-height-200px p-top-20px">
	<img src="{{ $activityImageThumb }}" class="img-thmb">
		<b class="font-size-20px">{{ $activityName }}</b>
		<hr>
		<i>
			&nbsp;
			<b>Date: </b>{{ ifset($selectedActivity->date) }} 
			| <b>Duration: </b>{{ $activityDuration }} 
		</i>
		<br/>
		<b>About Activity : </b>
		<span>
			{!! $activityDescription !!}
		</span>
		<br/>
</div>
<hr/>