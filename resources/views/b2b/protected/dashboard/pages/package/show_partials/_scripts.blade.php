{{-- bootstrap-daterangepicker --}}
<script>
	$('.datetimepicker').datetimepicker({
		formatDate:'d/m/Y',
		formatTime:'H:i',
		minDate: 0,
	});

	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

	});
</script>
{{-- /bootstrap-daterangepicker --}}


{{-- Model PopUp --}}
<script>
	$(document).on('click', ".btn-model", function(){

		var popupTarget = $(this).attr('data-target');
		var popupTitle = $(this).attr('data-title');
		var popupButton = $(this).attr('data-button');
		var popupBodyId = $(this).attr('data-bodyid');
		var popupFooterId = $(this).attr('data-footerid');

		var popupBody = $('#'+popupBodyId).html();
		var popupFooter = $('#'+popupFooterId).html();
		
		// console.log(popupTitle);
		// console.log(popupFooter);
		// var popupSize = '';
		
		// alert(popupTitle+' '+popupTarget);

		// if(popupTarget == '.bs-example-modal-sm'){
		// 	popupSize = '2';
		// }

		$(popupTarget).find('.modal-title').html(popupTitle);
		$(popupTarget).find('.modal-body').empty();
		$(popupTarget).find('.modal-body').html(popupBody);
		$(popupTarget).find('.modal-footer').empty();
		$(popupTarget).find('.modal-footer').html(popupFooter);
		
		// if(popupButton == 'false'){
		// 	$('#myModalButton'+popupSize).hide();
		// }
	})
</script>
{{-- /model PopUp --}}

{{-- save Cost --}}
<script>
	$(document).on('click', '#btnSaveCost', function() {
		var netCost = parseInt($('#netCost').val());
		var profitCost = parseInt($('#profitCost').val());		
		var totalCost = (netCost + profitCost);

		var data = {
				"_token" : csrf_token,
				"netCost" : netCost,
				"margin" : profitCost,
				"totalCost" : totalCost
			}

		$.ajax({
			type:"post",
			url: "{{ urlSavePackageCost($package->client->id, $package->id) }}",
			data: data,
			success: function(responce, textStatus, xhr) {
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
		$("#totalCost").attr('data-ischanged', 0);
	});
</script>
{{-- /save Cost --}}

{{-- calculate auto while typing --}}
<script>
	$(document).ready(function() {
	    //this calculates values automatically 
	    $(".inputCalc").on("keydown keyup", function() {
	        calculateSum();
	    });
	});

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
	          $(this).css("background-color", "red");
	      }
	  });

		$("#totalCost").text(sum.toFixed(2));
		$("#totalCost").attr('data-ischanged', 1);
	}
</script>
{{-- calculate auto while typing --}}

{{-- set-followup --}}
<script>
	$(document).on('click', '.set-followup', function(){
		var datetime = $('.datetime-followup').val();
		var followup = $('.text-followup').val();
		if (datetime == '' || followup == '') {
			alert('Follow-Up can\'t be blank');
		}else{
			var data = {
					"_token" : "{{ Session::token() }}",
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
	      },

			});
		}

	});
</script>
{{-- /set-followup --}}

<script>
	$(document).on('click', '#run_pdf', function() {
		var ischanged = $("#totalCost").attr('data-ischanged');
		if (ischanged == 0) {
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
		}else{
			myAlert('You have changed in cost save cost first');
		}
	});
</script>