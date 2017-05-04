<?php 
	$accomoHtml = trimHtml(
									view($viewDir.'.partials.html_partials.container')->render()
								);
	$accomoPropHtml = trimHtml(
											view($viewDir.'.partials.html_partials.props')->render()
										);
?>
<script>
	{{-- get rid object --}}
	function getRidObject(rid) {
		return idObject['rid_'+rid];
	}
	{{-- get rid object --}}

	{{-- show description --}}
	function showDescription(thisObj) {
		var popupTitle = proper($(thisObj).attr('data-title'));
		var popupBodyId = $(thisObj).attr('data-bodyid');
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


	{{-- checkChange --}}
	function checkChange(thisObj) {
		var type = $(thisObj).attr('data-type');
		var isChecked = $(thisObj).is(':checked');
		var parent = $(thisObj).closest('.pick-drop-container');
		/*console.log(parent);*/
		if (type == 'pick_up') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 0);
			}
		}
		else if (type == 'drop_off') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 0);
			}
		}
		else if(type == 'meal'){
			if (isChecked) {
				$(thisObj).addClass('selected');
			}
			else{
				$(thisObj).removeClass('selected');
			}
		}
	}
	{{-- /check Change --}}


	{{-- post hotel --}}
	function postAccomo(rid) {
		var ridObj 	= getRidObject(rid);
		var elem_id = ridObj.elem_id;
		$.ajax({
			type:"post",
			url: "{{ urlAccomoApi('fatch') }}/"+rid,
			data: {'_token' : csrf_token},
			success: function(response, textStatus, xhr) {
				var html = '';
				var response = JSON.parse(response);
				$('#loging_log').hide();
				var accomos = [];

				if (isset(response, 'hotels') && ridObj.mode == 'hotel') {
					var accomos = response.hotels;
				}
				else if (isset(response, 'cruises') && ridObj.mode == 'cruise') {
					var accomos = response.cruises;
				}

				$.each(accomos, function(i,v){
					html = makeAccomoObject(i, v, rid);
					$('#'+elem_id).append(html);
				})

			},
			error: function(xhr, textStatus) {
				$('#loging_log').hide();
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					postFgfAgoda(rid);
				}
			}
		});
	}
	{{-- post hotel --}}



	{{-- make hotel object --}}
	function makeAccomoObject(i, object, rid) {
		var code = object.id;
		var ukey = code+'_'+object.vendor;   {{-- uniqueKye = rid_id_vendor --}}
		var name = proper(object.name);
		var address = object.address.replace(/, , /g, ', '); 
		var sortAddress = address.substring(0, 50);
		var sortDescription = object.description.substring(0, 120);
		var starRatingHtml = star_Rating(object.star_rating);
		var ridObj = getRidObject(rid);
		var fid = ridObj.fid;
		var fdid = ridObj.fdid;
		var btnClass = 'btn-primary';
		var btnName = ridObj.mode  == 'hotel' ? 'Rooms' : 'Cabins';

		if (fid == code) {
			btnClass = 'btn-danger';
			btnName = 'Selected';
		}

		var hotel = {
				"ukey" : ukey,
				"name" : name,
				"code" : code,
				"fdid" : fdid,
				"ridObj" : ridObj,
				"btnName" : btnName,
				"address" : address,
				"btnClass" : btnClass,
				"propTabName" : btnName,
				"image" : object.image,
				"vendor" : object.vendor,
				"latitude" : object.latitude,
				"longitude" : object.longitude,
				"sortAddress" : sortAddress,
				"starRating" : object.star_rating,
				"description" : object.description,
				"starRatingHtml" : starRatingHtml,
				"sortDescription" : sortDescription
			};

		var sameElem = $('#'+ridObj.elem_id).find('.li_'+ukey);

		if (sameElem.length) {
			moveToTop(sameElem);
			return false;
		}
		else{
			return makeAccomoHtml(hotel);
		}
		{{-- $('#'+ridObj.elem_id).find('.li_'+ukey).remove();   Removing old cart --}}
	}
	{{-- make hotel object --}}


	{{-- make hotel html --}}
	function makeAccomoHtml(accomo) {
		var appendHtml = '';
		var searchWord = '';
		appendHtml += '{!!$accomoHtml!!}';
		return appendHtml;
	}
	{{-- make hotel html --}}


	{{-- Choose prop --}}
	function chooseProp(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		var parentLi = $(thisObj).closest('.main-list-item');
		$(parent).find('.hotel-detail').addClass('off');
		$(parentLi).find('.hotel-detail').addClass('on').removeClass('off');
		$(parent).find('.hotel-detail.off').hide();
		$(parentLi).find('.hotel-detail').toggle();

		var hasElem = $(parentLi).find('.btn-bookprop');
		if (hasElem.length == 0) {
			$('#loging_log').show();
			var rid = $(parent).attr('data-rid');
			var vdr = $(thisObj).attr('data-vdr');
			var fid = $(thisObj).attr('data-fid');
			var data = {
					"fid" : fid,
					"rid" : rid,
					"vdr" : vdr,
					"_token" : csrf_token
				};

			$.ajax({
				type:"post",
				url: "{{ urlAccomoApi('fatch/prop') }}/"+rid,
				data: data,
				success: function(response, textStatus, xhr) {
					response = JSON.parse(response);
					response = $.extend({}, response, data);
					populateInTab(response);
					$('#loging_log').hide();
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
					}
					$('#loging_log').hide();
				}
			});
		}
	}
	{{-- /Choose prop --}}



	{{-- populate in tab --}}
	function populateInTab(obj) {
		var ukey = obj.fid+'_'+obj.vdr+'_'+obj.rid;
		var ridObj = getRidObject(obj.rid);
		var props = [];
		if (ridObj.mode == 'hotel') {
			invokeMap(ukey);
			props = obj.rooms;
		}
		else if(ridObj.mode == 'cruise'){
			props = obj.cabins;
		}

		$.each(props,function(propKey, prop) {
			prop['fid'] = obj.fid;
			prop['rid'] = obj.rid;
			prop['svdr'] = obj.vdr;
			prop['proptype'] = '';

			if (ridObj.mode == 'hotel') {
				prop['proptype'] = prop.roomtype;
			}
			else if(ridObj.mode == 'cruise'){
				prop['proptype'] = prop.cabintype;
			}

			$('#'+ukey+'_props').append(makePropHtml(prop));
			invokeIcheck('#'+ukey+'_props');
		});

		$.each(obj.images, function(imagekey, image) {
			$('#'+ukey+'_gallary').find('.gallery.cf').append(makeGallaryHtml(image));
		});
	}
	{{-- /populate in tab --}}


	{{-- make prop html --}}
	function makePropHtml(obj) {
		var rmdid = '';
		var btnClass = 'btn-primary';
		var btnName = 'Add';
		var propId = obj.id;
		var propType = obj.proptype;
		var propImage = obj.image;
		var propVdr = obj.vdr;
		var ridObj = getRidObject(obj.rid);
		var selectedProps = ridObj.props;
		var mode = ridObj.mode;
		var checkExits = (
											ridObj.fid == obj.fid && 
											isset(selectedProps, propId) && 
											selectedProps[propId].vdr == obj.vdr
										);
		if (checkExits) {
			rmdid = selectedProps[propId].id;
			btnClass = 'btn-danger';
			btnName = 'Remove';
		}

		return '{!! $accomoPropHtml !!}';
	}
	{{-- /make prop html --}}


	{{-- make gallary html --}}
	function makeGallaryHtml(obj) {
		return '<div class="height-160px width-48-p"><img class="width-100-p height-100p" src="'+obj+'" /></div>'
	}
	{{-- /make gallary html --}}


	{{-- invoke map --}}
	function invokeMap(ukey) {
		var src = $('#'+ukey+'_map').attr('data-src');
		$('#'+ukey+'_map').html('<div class="m-top-5"><iframe width="100%" height="360" src="'+src+'" ></iframe></div>');
	}
	{{-- /invoke map --}}


	{{-- Book prop --}}
	function bookProp(thisObj) {
		var parent = $(thisObj).closest('.hotel-detail');
		var parentLi = $(thisObj).closest('.main-list-item');
		var parentUl = $(thisObj).closest('.list.list-unstyled');

		$(parentUl).find('.btn-chooseProp').addClass('off').removeClass('on');
		
		if ($(thisObj).hasClass("btn-primary")) {
			$(thisObj).addClass('btn-danger')
									.text('Remove')
										.removeClass('btn-primary');
			addProp(thisObj);
		}
		else if ($(thisObj).hasClass("btn-danger")) {
			$(thisObj).addClass('btn-primary')
									.text('Add')
										.removeClass('btn-danger');
			removeProp(thisObj);
		}

		var selected = $(parent).find('.btn-danger');
		if (selected.length > 0) {
			$(parentLi).find('.btn-chooseProp')
										.addClass('on btn-danger')
											.text('Selected')
												.removeClass('off btn-primary');

			$(parentUl).find('.btn-chooseProp.off')
										.addClass('btn-dark')
											.Prop('disabled', true)
												.removeClass('btn-primary');
		}
		else{
			$(parentUl).find('.btn-chooseProp')
										.addClass('btn-primary')
											.text('props')
												.removeClass('btn-dark')
													.removeClass('btn-danger')
														.Prop('disabled', false);
			removeHotel(thisObj);
		}
	}
	{{-- /Book prop --}}



	function addProp(thisObj) {
		var parentLi = $(thisObj).closest('.main-list-item');
		var rid = $(parentLi).closest('.list.list-unstyled').attr('data-rid');
		var chooseProp = $(parentLi).find('.btn-chooseProp');
		var fid = $(chooseProp).attr('data-fid');
		var fvdr = $(chooseProp).attr('data-vdr');
		var fdid = $(chooseProp).attr('data-fdid');
		var rmid = $(thisObj).attr('data-rmid');
		var rmvdr = $(thisObj).attr('data-vdr');
		var propContainer = $(thisObj).closest('.prop-container');
		var pickUpVal = $(propContainer).find('.h-pick-up').val();
		var dropOffVal = $(propContainer).find('.h-drop-off').val();
		var pickUpSelect = $(propContainer).find('.h-pick-up').data('selected');
		var dropOffSelect = $(propContainer).find('.h-drop-off').data('selected');
		var lunch = $(propContainer).find('.meal.lunch.selected').data('meal');
		var dinner = $(propContainer).find('.meal.dinner.selected').data('meal');
		var breakfast = $(propContainer).find('.meal.breakfast.selected').data('meal');

		var data = {
					"fid" : fid,
					"fdid" : fdid,
					"fvdr" : fvdr,
					"rmid" : rmid,
					"rmvdr" : rmvdr,
					"pu" : pickUpVal, {{-- pick_up --}}
					"pus" : pickUpSelect, {{-- pick_up_selected --}}
					"do" : dropOffVal, {{-- drop_off --}}
					"dos" : dropOffSelect, {{-- drop_off_selected --}}
					"breakfast" : breakfast,
					"lunch" : lunch,
					"_token" : csrf_token
				};

		$.ajax({
			type:"post",
			url: "{{ urlAccomoBuilder('prop/add') }}/"+rid,
			data: data,
			success: function(response, textStatus, xhr) {
				response = JSON.parse(response);
				$(chooseProp).attr('data-fdid', response.fdid);
				$(thisObj).attr('data-rmdid', response.rmdid);
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
				}
			}
		});
	}




	function removeProp(thisObj) {
		var parentLi = $(thisObj).closest('.main-list-item');
		var chooseProp = $(parentLi).find('.btn-chooseProp');
		var rmdid = $(thisObj).attr('data-rmdid');
		var rid = $(thisObj).closest('.list.list-unstyled').attr('data-rid');
		var ridObj =  getRidObject(rid);
		var data = {
					"rmdid" : rmdid,
					"_token" : csrf_token
				};

		$.ajax({
			type:"post",
			url: "{{ urlAccomoBuilder('prop/remove') }}/"+rid,
			data: data,
			success: function(response, textStatus, xhr) {
				response = JSON.parse(response);
				if (response.is_copied == 1) {
					$(chooseProp).attr('data-fdid', response.fdid);
					if (ridObj.mode == 'hotel') {
						$.each(response.rooms, function(i,v) {
							$(parentLi).find("[data-rmdid='" + i + "']").attr('data-rmdid', v);
						});
					}else if (ridObj.mode == 'cruise') {
						$.each(response.cabins, function(i,v) {
							$(parentLi).find("[data-rmdid='" + i + "']").attr('data-rmdid', v);
						});
					}
				}
				$(thisObj).attr('data-rmdid','');
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
				}
			}
		});
	}




	function removeHotel(thisObj) {
		var parentUl = $(thisObj).closest('.list.list-unstyled');
		var parentLi = $(thisObj).closest('.main-list-item');
		var chooseProp = $(parentLi).find('.btn-chooseProp');
		var fdid = $(chooseProp).attr('data-fdid');
		var rid = $(parentUl).attr('data-rid');
		var data = {
					"fdid" : fdid,
					"_token" : csrf_token
				};

		$.ajax({
			type:"post",
			url: "{{ urlAccomoBuilder('remove') }}/"+rid,
			data: data,
			success: function(response, textStatus, xhr) {
				$(chooseProp).attr('data-fdid','');
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
				}
			}
		});
	}



	{{-- move to top --}}
	function moveToTop(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).prepend(thisObj)
							.find('.border-green-2px')
								.removeClass('border-green-2px');

		$(thisObj).find('.x_panel.glowing-border').addClass('border-green-2px');
	}
	{{-- /move to top --}}


	{{-- find next event --}}
	function nextAccomoEvent(thisObj) {
		$('#loging_log').show();
		rid = $(thisObj).attr('data-rid');
		ridObj = getRidObject(idObject.crid);
		if (ridObj.nrid == "NaN") {
			setTimeout(function () {    
				document.location.href = "{{url('dashboard/package/builder/event/'.$package->token.'/accommodation')}}";
			}, 5000);
		}
		else{
			clickAtab(ridObj.nrid);
			$('#loging_log').hide();
		}
	}
	{{-- /find next event --}}

	function clickAtab(rid) {
		$('#a_rid_'+rid).click();
	}

	function setCrid(rid) {
		idObject.crid = rid;
	}

	function postSearchHotel() {
		hideSpinIcon();
		$('#loging_log').show();
		var name = $('#filter_search').val();
		var rid = $('#tab_menu').find('.active').attr('data-rid');
		var ridObj = getRidObject(rid);
		var elem_id = ridObj.elem_id;
		var data = {
				'name' : name,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/hotels/search/') }}/"+rid+'?format=json',
			data: data,
			success: function(response, textStatus, xhr) {
				var html = '';
				var response = JSON.parse(response);
				var hotels = response.hotels;

				$('#loging_log').hide();
				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeHotelObject(i, v, rid);
						$('#'+elem_id).append(html);
					});
				}
			}
		});
	}




	function postFgfAgodaDetail(ids){
		var ukey = ids.hid+'_fgfa';
		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/detail/') }}/"+ids.rid,
			data: ids,
			success : function(response){
				$('#'+ukey+'_about').html(response);
			}
		});
	}



	{{-- add to cart --}}
	function postAddtoCartHotel(data) {

		/*Object must be like this 
		var data = {
			"_token" : csrf_token,
			"did" : did,
			"index" :id,
			"vendor" : vendor
		}*/

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/builder/hotel/prop/book/') }}/"+data.rid,
			data: data,
			success : function(response){
				response = JSON.parse(response);
				if (response.status == 200) {
					$('#a_rid_'+data.nrid).click();
					$(window).scrollTop(0);
				}else{
					alert('Something went wrong please try again.');
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				alert('Something went wrong please try again.');
			}
		});
	}
	{{-- add to cart --}}
</script>