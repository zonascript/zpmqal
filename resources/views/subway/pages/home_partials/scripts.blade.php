<script>
	$(document).on('change', '.radio-md.book', function () {
		console.log('test');
		var val = $(this).val();
		var id = val == 'pay_now' ? '#form_pay_now' : '#form_reserve';
		var oppid = val == 'pay_now' ? '#form_reserve' : '#form_pay_now';
		$(oppid).hide();
		$(id).show();
	});

	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_2",
			format : "DD/MM/YYYY",
			minDate : new Date(),
			startDate: new Date(),
		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});
	});

	$(document).on('click', '.show-book-popup', function () {
		$('.book-popup.popup-model').show();
	});


	$(document).on('click', '.close.book-popup', function () {
		$('.book-popup.popup-model').hide();
	});

</script>