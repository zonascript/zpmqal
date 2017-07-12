<script>
	{{-- show description --}}

	function showDescription(thisObj) {
		var popupTitle = proper($(thisObj).data('title'));
		var popupBodyId = $(thisObj).data('bodyid');
		var popupBody = $('#'+popupBodyId).html();
		$.alert({
			backgroundDismiss: true,
			keyboardEnabled: true,
			title: popupTitle,
			content: popupBody,
			columnClass: 'col-md-6 col-md-offset-3'
		});
	}

	{{-- show description --}}

	{{-- set follow up --}}

	function setFollowUp(thisObj) {
		var datetime = $('.datetime-followup').val();
		var followup = $('.text-followup').val();
		if (datetime == '' || followup == '') {
			alert('Follow-Up can\'t be blank');
		}
		else{
			var data = {
					"_token" : csrf_token,
					"pid" : "{{ $package->id }}",
					"datetime" : datetime, 
					"followup" : followup,
				};

			$.ajax({
				type:"post",
				url: "{{ url('/dashboard/follow-up/') }}",
				data: data,
				success: function(response, textStatus, xhr) {
					$('.datetime-followup, .text-followup').val('');
					console.log(response);
					response = JSON.parse(response);
					alert(response.response);
				},

				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
				}
			});
		}
	}

	{{-- /set follow up --}}

	{{-- save cost --}}

	function saveCost() {
		var visa = $('#visaCostCheckbox').is(':checked');
		visa = visa ? 1 : 0;
		var costError = $('#totalCost').attr('data-error');
		if (costError == 1) {
			$.alert({
				title: 'Alert!',
				content: '<h2>I think you have given wrong value in cost</h2>'
			});
		}
		else if (alertVisa()) {

			var visaCost = parseInt($('#visaCost').val());
			var netCost = parseInt($('#netCost').val());
			var profitCost = parseInt($('#profitCost').val());		
			var totalCost = (netCost + profitCost);

			var data = {
					"_token" : csrf_token,
					"visa" : visa,
					"visaCost" : visaCost,
					"netCost" : netCost,
					"margin" : profitCost,
					"totalCost" : totalCost
				}

			$.ajax({
				type:"post",
				url: "{{ route('saveCost', $package->token) }}",
				data: data,
				success: function(response, textStatus, xhr) {
					response = JSON.parse(response);
					setHref(response.token);
					$.alert({
						title: 'Success!',
						content: '<h2>'+response.response+'</h2>'
					});
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
				}
			});

			$("#totalCost").attr('data-ischanged', 0)
											.attr('data-error', 0);

		}
	}

	{{-- /save cost --}}

	function setHref(token) {
		var url = "{{ route('yourPackage', $package->token) }}?ctk="+token;
		$('#input_html_link').val(url);
		$('#a_html_link').attr('href', url);
	}

	{{-- run pdf --}}

	function runPdf() {
		var ischanged = $("#totalCost").attr('data-ischanged');
		var costError = $('#totalCost').attr('data-error');
		console.log(ischanged);
		
		if (costError == 1) {
			$.alert({
				title: 'Alert!',
				content: '<h2>I think you have given wrong value in cost</h2>'
			});
		}
		else if (ischanged == 1) {
			$.alert({
				title: 'Alert!',
				content: '<h2>You have changed in cost save cost first</h2>'
			});
		}
		else if (alertVisa()) {
			var data = {"_token" : csrf_token}

			$.ajax({
				type:"get",
				url: "{{ url('/dashboard/package/html/'.$package->id) }}",
				data: data,
				success: function(response, textStatus, xhr) {
					response = JSON.parse(response);
					if (response.status == 200) {
						var pdfUrl = '{{ url('/dashboard/package/pdf/') }}/'+response.hash_id;
						var htmlUrl = '{{url('/your/package/detail/')}}/'+response.hash_id;
						$('#btn_pdf').attr('href', pdfUrl);
						$('#show_html_link').val(htmlUrl);
						window.open(pdfUrl, '_blank');
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
				}

			});
		}
	}

	{{-- /run pdf --}}


	{{-- visa confirmation --}}

	function alertVisa() {
		var isChecked = $('#visaCostCheckbox').is(':checked');
		var yes = $('#visaCost').attr('data-yes');
		var no = $('#visaCost').attr('data-no');
		var result = true;
		if (yes == 0 && no == 0 && !isChecked) {
			result = false;
			$.confirm({
				title  : 'Visa',
				content: '<h2>Would you like to add visa cost</h2>',
				buttons: {
					Yes: {
						btnClass: 'btn-blue',
						action: function(){
							// $('visaCostCheckbox').iCheck({
							// 	checkboxClass: 'icheckbox_flat-green'
							// });
							$('#visaCost').addClass('border-red');
						}
					},
					No: {
						btnClass: 'btn-red',
						action: function(){
							$('#visaCost').attr('data-no', 1);
						}
					},
				}
			});
		}

		return result;
	}

	{{-- /visa confirmation --}}

	{{-- error in cost --}}

	function setErrorCost(error) {
		$("#totalCost").attr('data-error', error);
	}

	{{-- /error in cost --}}

	{{-- calculateSum --}}

	function calculateSum() {
		var sum = 0;
		//iterate through each textboxes and add the values
		$(".inputCalc").each(function() {
			//add only if the value is number
			if (!isNaN(this.value) && this.value.length != 0) {
				sum += parseFloat(this.value);
				$(this).css("background-color", "#FEFFB0");
			}
			else if (this.value.length != 0){
				setErrorCost(1)
				$(this).css("background-color", "red");
			}

			// if ($(this).attr('id') == 'visaCost' && $(this).attr('data-no') == 1) {
			// 	setErrorCost(0);
			// }

		});

		$("#totalCost").text(sum.toFixed(2));
		$("#totalCost").attr('data-ischanged', 1);
	}

	{{-- /calculateSum --}}
</script>