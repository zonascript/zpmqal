<script>
	{{-- bootstrap-daterangepicker --}}
	$('.datetimepicker').datetimepicker({
		formatDate:'d/m/Y',
		formatTime:'H:i',
		minDate: 0,
	});
	{{-- /bootstrap-daterangepicker --}}

	{{-- calculate auto while typing --}}
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
	{{-- /calculate auto while typing --}}


	{{-- Model PopUp --}}
	$(document).on('click', ".btn-model", function(){
		showDescription(this);	
	})
	{{-- /model PopUp --}}


	{{-- set-followup --}}
	$(document).on('click', '.set-followup', function(){
		setFollowUp();	
	});
	{{-- /set-followup --}}

	{{-- save Cost --}}
	$(document).on('click', '#btnSaveCost', function() {
		saveCost();	
	});
	{{-- /save Cost --}}

	{{-- run pdf --}}
	$(document).on('click', '#run_pdf', function() {
		runPdf();
	});
	{{-- /run pdf --}}

	$(document).on('click', '#save_note', function () {
		savePackageNote();
	});
</script>



@include($viewPath.'.show_partials.scripts.function')
