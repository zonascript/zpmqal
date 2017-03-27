<?php
	$activityDate = ifset($activity->date);
	$activityName = ifset($activity->detail->name);
	$activityMode = activityMode(ifset($activity->mode));
	$activityTiming = activityTiming(ifset($activity->timing));
	$activityDescription = ifset($activity->detail->description);
	$activityImageThumb = ifset($activity->detail->image, urlDefaultImageActivity());
?>

<div class="box-stack min-height-200px p-top-20px">
	<img src="{{ $activityImageThumb }}" class="img-thmb">
		<b class="font-size-20px">{{ $activityName }}</b>
		<hr>
		<i>
			&nbsp;
			<b>Date: </b>{{ $activityDate }} 
			| <b>Timing: </b>{{ $activityTiming }} 
			| <b>Transfer: </b>{{$activityMode}}
		</i>
		<br/>
		<b>About Activity : </b>
		<span>
			{!! $activityDescription !!}
		</span>
		<br/>
</div>
<hr/>