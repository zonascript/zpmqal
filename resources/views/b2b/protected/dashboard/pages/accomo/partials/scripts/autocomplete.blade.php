<script>
	$(document).on('keyup paste', '#filter_search', function(e) {
		var name = $(this).val();
		if (name.length > 2) {
			/*showSpinIcon();*/
			var rid = idObject.crid;
			var url = '{{ urlAccomoApi("search/name") }}/'+rid+'?format=json&_token='+csrf_token;

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
					populateHtml({'hotels' : [ui.item]}, rid, true);
					/*hideSpinIcon();*/
					return false;
				}
			})
			.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
				/*hideSpinIcon();*/
				return $( "<li>" )
				.append( "<a>" + item.name + "</a>" )
				.appendTo( ul );
			};
		}
	});
</script>