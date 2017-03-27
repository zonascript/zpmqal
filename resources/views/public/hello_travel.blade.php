<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://b2b.flygoldfinch.dev/common/dashboard/vendors/jquery/dist/jquery.min.js"></script>
	<script>
		$(document).ready(function () {
			var html = ''
			$('[role="button"]').each(function () {
				data = $(this).attr('data-content');
				if (data != undefined) {
					html += $(this).attr('data-content');
				}
			});
			$.ajax({
				type : "post",
				url : "{{ Request::url() }}/save",
				data : { '_token' : '{{ csrf_token() }}', 'html' : html },
				success: function(responce, textStatus, xhr) {
					console.log(responce);
					if (responce != 'done') {
	         	document.location.href = responce;
					}else{
						alert(responce);
					}
        }
			});
			console.log(html);
		});
	</script>
</head>
	{!! $html !!}
	
</html>