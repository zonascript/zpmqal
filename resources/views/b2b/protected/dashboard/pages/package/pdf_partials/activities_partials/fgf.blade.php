<?php
	$activityImageThumb = ifset($fgfActivity->Images[0], urlDefaultImageActivity());
	$activityName = ifset($fgfActivity->ActivityName);
	$activityDescription = ifset($fgfActivity->Description);
?>

<div class="box-stack min-height-200px p-top-20px">
	<img src="{{ $activityImageThumb }}" class="img-thmb">
		<b class="font-size-20px">{{ $activityName }}</b>
		<hr>
		<i>
			&nbsp;<b>Date: </b>{{ ifset($selectedActivity->date) }}
			@if (isset($selectedActivity->Timing) && is_array($selectedActivity->Timing))
				@foreach ($selectedActivity->Timing as $activityTiming)
					 | <b>OpeningTime : </b>{{ date("H:i", strtotime(ifset($activityTiming->OpeningTime))) }} | <b>ClosingTime : </b>{{ date("H:i", strtotime(ifset($activityTiming->ClosingTime))) }}<br/>
				@endforeach
			@endif
		</i>
		<br/>
		<b>About Activity : </b>
		<span>
			{!! $activityDescription !!}
		</span>
		<br/>
</div>
<hr/>