
<script>

	{{-- autocomplete --}}
	$(document).on('keypress paste	{{--keyup  keydown --}}', '#filter_search', function(e) {
		var key = e.which;
		if(key == 13){ /*the enter key code*/
			searchActivities();
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				showSpinIcon();
				var rid = idObject.crid;
				url = '{{ url("api/package/activities/names") }}/'+rid+'?format=json&_token='+csrf_token;
				$(this).autocomplete({ source: url });
			}
		}
	});


	$(document).on('keyup paste', '#filter_search', function(e) {
		var key = e.which;

		if(key == 13){ /*the enter key code*/
			searchActivities();
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				showSpinIcon();
				var rid = idObject.crid;
				var url = '{{ url("api/package/activities/search") }}/'+rid+'?format=json&_token='+csrf_token;

				$(this).autocomplete({
					minLength: 0,
					source: url,
					focus: function( event, ui ) {
						$(this).val( ui.item.name );
						return false;
					},
					select: function( event, ui ) {
						$(this).val( ui.item.name )
										.attr('data-code', ui.item.code);

						populateHtml(ui.item, rid);
						hideSpinIcon();
						return false;
					}
				})
				.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
					hideSpinIcon();
					return $( "<li>" )
					.append( "<a>" + item.name + "</a>" )
					.appendTo( ul );
				};
			}
		}
	});
</script>