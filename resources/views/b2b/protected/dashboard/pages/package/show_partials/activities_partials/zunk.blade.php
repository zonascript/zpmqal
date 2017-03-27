@if ($selectedActivity->vendor == 'fgf' && !is_null($fgfActivities))
	<?php
		$fgfActivity = null;
		if (isset($fgfActivities->ActivitySearchResult->ActivityResults[$selectedActivity->index])) {
			$fgfActivity = $fgfActivities
										->ActivitySearchResult
											->ActivityResults[$selectedActivity->index];
		}
	?>
	@if (!is_null($fgfActivity))
		@include('b2b.protected.dashboard.pages.package.show_partials.activities_partials.fgf')
	@endif
@elseif($selectedActivity->vendor == 'viator' && !is_null($viatorActivities))
	<?php
		$viatorActivity = null;
		if (isset($viatorActivities->data[$selectedActivity->index])) {
			$viatorActivity = $viatorActivities->data[$selectedActivity->index];
		}
	?>
	@if (!is_null($viatorActivity))
		@include('b2b.protected.dashboard.pages.package.show_partials.activities_partials.viator')
	@endif
@endif