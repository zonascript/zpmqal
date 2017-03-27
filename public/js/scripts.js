function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}

/*!
 * toggleAttr() jQuery plugin
 * @link http://github.com/mathiasbynens/toggleAttr-jQuery-Plugin
 * @description Used to toggle selected="selected", disabled="disabled", checked="checked" etc…
 * @author Mathias Bynens <http://mathiasbynens.be/>
 */
// jQuery.fn.toggleAttr = function(attr) {
//  return this.each(function() {
//   var $this = $(this);
//   $this.attr(attr) ? $this.removeAttr(attr) : $this.attr(attr, attr);
//  });
// };

$.fn.toggleAttr = function(attr, attr1, attr2) {
  return this.each(function() {
    var self = $(this);
    if (self.attr(attr) == attr1)
      self.attr(attr, attr2);
    else
      self.attr(attr, attr1);
  });
};

function hotel_roomSearch(value){
	$('#hoteldetail-'+value).toggle();
	alert($(this.element).attr('class'));
}

function showPopUp(title = Title, body = '') {
  $('#popup_title').html(title);
  $('#popup_body').html(body);
  $('.popup-model').fadeIn();
}

function hidePopUp() {
  $('.popup-model').fadeOut();
}

