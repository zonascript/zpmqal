{{-- bootstrap-daterangepicker --}}
<script>
	$('.datetimepicker').datetimepicker({
		formatDate:'d/m/Y',
		formatTime:'H:i',
		minDate: 0,
	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- calculate auto while typing --}}
<script>
	$(document).ready(function() {
			//this calculates values automatically 
			$(".inputCalc").on("keydown keyup", function() {
				var id = $(this).attr('id');

				if ($.isNumeric(this.value)) {
					setErrorCost(0)
					if (id == 'visaCost') {
						$(this).attr('data-no', 0);
						$(this).attr('data-yes', 1);
						$(this).removeClass('border-red');
					}
				}

				calculateSum();
			});
	});
</script>
{{-- /calculate auto while typing --}}


{{-- Model PopUp --}}
<script>
	$(document).on('click', ".btn-model", function(){
		showDescription(this);
	})
</script>
{{-- /model PopUp --}}


{{-- set-followup --}}
<script>
	$(document).on('click', '.set-followup', function(){
		setFollowUp();
	});
</script>
{{-- /set-followup --}}

{{-- save Cost --}}
<script>
	$(document).on('click', '#btnSaveCost', function() {
		saveCost();
	});
</script>
{{-- /save Cost --}}

{{-- run pdf --}}
<script>
	$(document).on('click', '#run_pdf', function() {
		runPdf();
	});
</script>
{{-- /run pdf --}}

@include($viewPath.'.show_partials.scripts.function')
