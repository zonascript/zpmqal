$(document).on('click', '.btn-decrease', function () {
	var elem = $(this).attr('field');
	var max = parseInt($(elem).attr('data-max'), 10);
	var min = parseInt($(elem).attr('data-min'), 10);
	var sin = $(elem).attr('data-singular');
	var plu = $(elem).attr('data-plural');
	var nextElem = $(elem).next();
	var value = parseInt($(elem).val(), 10);
	value = isNaN(value) ? 0 : value;
	value < 1 ? value = 1 : '';
	value--;
	var text = (value > 1) ? plu : sin;
	(value == min)
	? $(this).prop('disabled', true)
	: $('.btn-increase[field="'+elem+'"]').prop('disabled', false);
	$(elem).val(value);
	$(nextElem).html(text);
});

$(document).on('click', '.btn-increase', function () {
	var elem = $(this).attr('field');
	var max = $(elem).attr('data-max');
	var min = $(elem).attr('data-min');
	var sin = $(elem).attr('data-singular');
	var plu = $(elem).attr('data-plural');
	var nextElem = $(elem).next();
	var value = parseInt($(elem).val(), 10);
	value = isNaN(value) ? 0 : value;
	value++;
	var text = (value > 1) ? plu : sin;
	(value == max )
	? $(this).prop('disabled', true) 
	: $('.btn-decrease[field="'+elem+'"]').prop('disabled', false);
	$(elem).val(value);
	$(nextElem).html(text);
});