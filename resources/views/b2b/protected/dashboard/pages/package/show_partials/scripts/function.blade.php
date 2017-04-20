
{{-- show description --}}
<script>
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
</script>
{{-- show description --}}

{{-- set follow up --}}
<script>
	function setFollowUp(thisObj) {
		var datetime = $('.datetime-followup').val();
		var followup = $('.text-followup').val();
		if (datetime == '' || followup == '') {
			alert('Follow-Up can\'t be blank');
		}
		else{
			var data = {
					"_token" : csrf_token,
					"packageDbId" : "{{ $package->id }}",
					"fullname" : "{{ isset($package->client->fullname) ? $package->client->fullname : '' }}",
					"datetime" : datetime, 
					"followup" : followup,
				};

			$.ajax({
				type:"post",
				url: "{{ url('/dashboard/follow-up/') }}",
				data: data,
				success: function(responce, textStatus, xhr) {
					$('.datetime-followup, .text-followup').val('');
					console.log(responce);
					responce = JSON.parse(responce);
					alert(responce.responce);
				},

				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
				}
			});
		}
	}
</script>
{{-- /set follow up --}}

{{-- save cost --}}
<script>
	function saveCost() {
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
					"visaCost" : visaCost,
					"netCost" : netCost,
					"margin" : profitCost,
					"totalCost" : totalCost
				}

			$.ajax({
				type:"post",
				url: "{{ urlSavePackageCost($package->client->id, $package->id) }}",
				data: data,
				success: function(responce, textStatus, xhr) {
					responce = JSON.parse(responce);
					$.alert({
						title: 'Success!',
						content: '<h2>'+responce.responce+'</h2>'
					});
				},

				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
				}
			});
			$("#totalCost").attr('data-ischanged', 0);
		}
	}
</script>
{{-- /save cost --}}

{{-- run pdf --}}
<script>
	function runPdf() {
		var ischanged = $("#totalCost").data('ischanged');
		var costError = $('#totalCost').data('error');
		
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
				success: function(responce, textStatus, xhr) {
					responce = JSON.parse(responce);
					if (responce.status == 200) {
						var pdfUrl = '{{ url('/dashboard/package/pdf/') }}/'+responce.hash_id;
						var htmlUrl = '{{url('/your/package/detail/')}}/'+responce.hash_id;
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
</script>
{{-- /run pdf --}}


{{-- visa confirmation --}}
<script>
	function alertVisa() {
		// var isChecked = $('#visaCostCheckbox').is(':checked');
		var yes = $('#visaCost').attr('data-yes');
		var no = $('#visaCost').attr('data-no');
		var result = true;
		if (yes == 0 && no == 0) {
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
</script>
{{-- /visa confirmation --}}

{{-- error in cost --}}
<script>
	function setErrorCost(error) {
		$("#totalCost").attr('data-error', error);
	}
</script>
{{-- /error in cost --}}

{{-- calculateSum --}}
<script>
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
</script>
{{-- /calculateSum --}}