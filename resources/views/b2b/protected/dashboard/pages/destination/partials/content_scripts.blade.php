{{-- autocomplete --}}
<script>
	$(document).on('keypress', '.location', function(e) {
			$(this).autocomplete({ source: "{{url("dashboard/tools/destination")}}" });
	});
</script>
{{-- /autocomplete --}}

{{-- form submition --}}
{{-- <script>
	$(document).on('click','#formSubmit', function(){
		var data = {
			"_token" : "{{ csrf_token() }}",
			"route_id" : route_id,
			"destination" : $('')
		}

		console.log(JSON.stringify(data));


		$.ajax({
			type:"post",
			url: "{{ Request::url() }}", 
			data: data,
			success: function(responce, textStatus, xhr) {
				if(xhr.status == 200){
					responce_obj = JSON.parse(responce);
					console.log(responce_obj.nextUrl);
					document.location.href = responce_obj.nextUrl;
				}
      },

      error: function(xhr, textStatus) {
				// console.log(textStatus);
				// console.log(xhr.status);
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
      },
		});
	});
</script> --}}
{{-- /form submition --}}