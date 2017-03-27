
<script>
	function toggleElement(elemId) {
		@foreach ($idObject as $objectKey => $objectValue)
			@if (!is_array($objectValue) && $objectValue->next_rid != "NaN")
				if (elemId == {{$objectValue->rid}}) {
					document.getElementById('a_flight_{{ $objectValue->next_rid }}').click();
				}
			@endif
		@endforeach
	}
	
	function appendHtml(elemId, responce) {
		// console.log(elemId);
		@foreach ($idObject as $objectKey => $objectValue)
			@if (!is_array($objectValue))
				if (elemId == {{$objectValue->rid}}) {
					var selectorId{{$objectValue->rid}} = document.getElementById('fligth_{{ $objectValue->rid }}');
					{{-- console.log(selectorId{{$objectValue->rid}});--}}
					selectorId{{$objectValue->rid}}.insertAdjacentHTML('beforeend', responce);
				};
			@endif
		@endforeach
	}
</script>


