
{{-- Select2 --}}
<script>
	$(document).ready(function() {
		$(".select2_multiple").select2({
			maximumSelectionLength:10,
			placeholder: "Assign To",
			allowClear: true,
			width:'100%'
		});

	});

	$(window).load(function() {
		loopHotelDetail();
	});
</script>
{{-- /Select2 --}}


<script>
	$(document).on('ifChanged', 'input', function() {
		var type = $(this).attr('data-type');
		var isChecked = $(this).is(':checked');
		/*console.log(isChecked);*/
		if (type == 'todo') {
			var toDoId = $(this).attr('data-id');
			if (isChecked) {
				$('#menu_todo_text_'+toDoId).addClass('line-through');
			}else{
				$('#menu_todo_text_'+toDoId).removeClass('line-through');
			}

			changeStatusTodo(toDoId);

			setTimeout( function(){ 
				refreashTodo('#menu_todo');
				/*Do something after 1 second */
			}  , 5000 );
		}
	});
</script>



{{-- Saving to do --}}
<script>
	$(document).on('click', '.btn-to-do', function(){

		var to_do_select = $('#to_do_select').val();
		var to_do_text = $('#to_do_text').val();

		var data = {
			"_token" : csrf_token,
			"toDoText" : to_do_text,
			"toDoSelect" : to_do_select
		};

		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo') }}",
			data : data,
		});

		setTimeout( function(){ 
			refreashTodo('#menu_todo');
			/*Do something after 1 second */
		}  , 1000 );

		$('#to_do_text').val('');
		$('.btn-to-do-close').click();
	});
</script>
{{-- /Saving to do --}}


<script>
	$(document).on('click', '.remove-to-do',function(){
		var toDoIndex = $(this).attr('data-index');
		removeTodo(toDoIndex);

		setTimeout( function(){ 
			refreashTodo('#menu_todo');
			/*Do something after 1 second */
		}  , 1000 );
	});
</script>



<script>
	function refreashLeadBox() {
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/enquiry/pending') }}",
			data : { "_token" : csrf_token },
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				var leadCount = responce.length ? responce.length : '';
				
				$('#menu_lead_box_count').html(leadCount);

				var html = '';
				$('#menu_lead_box').empty();
				$('#menu_lead_box').html('<li><h2>Lead Box</h2></li>');
				$.each(responce, function(i,v){
					elemId = i;
					html = makeLeadBoxHtml(i,v);
					$('#menu_lead_box').append(html);
				});
			},
		});
	}


	function makeLeadBoxHtml(i,Obj) {
		<?php
			$html = 'return \'<li>
					<a href="'.url('dashboard/package/all').'/\'+Obj.id+\'">
						<span>
							<span><b class="font-size-15">\'+Obj.fullname+\'</b></span>
							<span class="time">\'+Obj.created_at+\'</span>
						</span>
						<div><b>Mobile : </b>\'+Obj.mobile+\'</div>
						<span class="message"><b>Message : </b>\'+Obj.note+\'</span>
					</a>
				</li>\'';
			$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
			echo $html;
		?>
	}
</script>


<script>
	function refreashTodo(toDoId) {
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo/all/json') }}",
			data : { "_token" : csrf_token },
			success: function(responce, textStatus, xhr) {
					responce =  JSON.parse(responce);
					var html = makeTodoHtml(responce);
					if (responce.length) {
						$('#todos_count').text(responce.length);
					}
					$(toDoId).html(html);
					$('#menu_todo').find('input').iCheck({
						checkboxClass: 'icheckbox_flat-green'
					});
				},
		});
	}

	function makeTodoHtml(todos) {
		var html = '<li><h2>To-do Lists</h2></li>';
		$.each(todos, function(todokey, todo) {
			var toDoId = todo.id;
			var toDoText = todo.text;
			var toDoStatus = todo.status;
			var lineThrough = toDoStatus == 'active' ? '' : 'line-through';
			var isChecked = toDoStatus == 'active' ? '' : 'checked="checked"';

			<?php 
				$todoJsHtml = view('b2b.protected.dashboard.partials.script_partials.todo')
											->render();
				$todoJsHtml = trimHtml($todoJsHtml);
			?>
			html += '{!! $todoJsHtml !!}';
		});
		html += '<li><div class="text-center"><a href="{{ url('dashboard/todo') }}"><strong>See All Todo</strong><i class="fa fa-angle-right"></i></a></div></li>';
		return html;
	}

	function removeTodo(id) {
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo/remove') }}",
			data : { "_token" : csrf_token, "id" : id }
		});
	}

	function changeStatusTodo(id) {
		var data = { "_token" : csrf_token, "id" : id };

		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo/status') }}",
			data : data,
		});
	}
</script>

<script>
	function loopHotelDetail() {
		$.ajax({
			type : "get",
			url : "{{ url('a/l/htdetail') }}"
		});
	}
</script>

<script>
	function refreashTrack(){
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/package/track/json') }}",
			data : { "_token" : csrf_token},
			success: function(responce, textStatus, xhr) {
				responce =  JSON.parse(responce);
				$('#menu_track').empty();
				$('#menu_track').append('<li><h2>Package Status</h2></li>');
				var trackCount = responce.length ? responce.length : ''; 
				$('#menu_track_count').text(trackCount);
				$.each(responce, function(trackKey, track) {
					<?php 
						$trackJsHtml = view('b2b.protected.dashboard.partials.script_partials.track')->render();
						$trackJsHtml = trimHtml($trackJsHtml);
					?>
					$('#menu_track').append('{!! $trackJsHtml !!}');
				});
				$('#menu_track').append('<li><div class="text-center"><a href="{{ url('dashboard/package/track') }}"><strong>See All Track</strong><i class="fa fa-angle-right"></i></a></div></li>');
			}
		});
	}
</script>

<script>
	var vTimeOut;

	$(function() {
		vTimeOut= setInterval(refreashLeadBox, 20000);
		vTimeOut= setInterval(refreashTrack, 20000);
	});
</script>