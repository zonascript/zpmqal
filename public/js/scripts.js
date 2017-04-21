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


function isset(obj, key) {
  var result = false;
  
  if (obj.hasOwnProperty(key)) {
    result = true;
  }

  return result;
}


function star_Rating(count){
  var stars = '';
  for (var i = 0; i < 5; i++) {
    if (i <= count) {
      stars += '<i class="fa fa-star font-gold font-size-13"></i>';
    }else{
      stars += '<i class="fa fa-star font-size-13"></i>';
    }
  }
  return stars;
}

function proper(str) {
  str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
      return letter.toUpperCase();
  });
  return str;
}



function invokeIcheck(elem) {
  $(elem).find('input').iCheck({
    checkboxClass: 'icheckbox_flat-green'
  });
}
