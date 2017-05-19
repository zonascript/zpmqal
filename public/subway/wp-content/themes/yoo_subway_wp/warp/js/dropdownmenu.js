/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */

!function(t){var i=function(){};t.extend(i.prototype,{name:"dropdownMenu",options:{mode:"default",itemSelector:"li",firstLevelSelector:"li.level1",dropdownSelector:"ul",duration:600,remainTime:800,remainClass:"remain",matchHeight:!0,transition:"easeOutExpo",withopacity:!0,centerDropdown:!1,reverseAnimation:!1,fixWidth:!1,fancy:null,boundary:t(window),boundarySelector:null},initialize:function(i,n){this.options=t.extend({},this.options,n);var o=this,e=null,a=!1;if(this.menu=i,this.dropdowns=[],this.options.withopacity=t.support.opacity?this.options.withopacity:!1,this.options.fixWidth){var s=5;this.menu.children().each(function(){s+=t(this).width()}),this.menu.css("width",s)}if(this.options.matchHeight&&this.matchHeight(),this.menu.find(this.options.firstLevelSelector).each(function(i){var n=t(this),s=n.find(o.options.dropdownSelector).css({overflow:"hidden"});if(s.length){s.css("overflow","hidden").show(),s.data("init-width",parseFloat(s.css("width"))),s.data("columns",s.find(".column").length),s.data("single-width",s.data("columns")>1?s.data("init-width")/s.data("columns"):s.data("init-width"));var d=t("<div>").css({overflow:"hidden"}).append("<div></div>"),r=d.find("div:first");s.children().appendTo(r),d.appendTo(s),o.dropdowns.push({dropdown:s,div:d,innerdiv:r}),s.hide()}n.bind({mouseenter:function(h){if(a=!0,o.menu.trigger("menu:enter",[n,i]),e){if(e.index==i)return;e.item.removeClass(o.options.remainClass),e.div.hide().parent().hide()}if(!s.length)return active=null,void(e=null);s.parent().find("div").css({width:"",height:"","min-width":"","min-height":""}),s.removeClass("flip").removeClass("stack"),n.addClass(o.options.remainClass),d.stop().show(),s.show(),o.options.centerDropdown&&s.css("margin-left",-1*(parseFloat(s.data("init-width"))/2-n.width()/2));var p=s.css("width",s.data("init-width")).data("init-width");dpitem=o.options.boundarySelector?t(o.options.boundarySelector,d):d,boundary={top:0,left:0,width:o.options.boundary.width()},r.css({"min-width":p});try{t.extend(boundary,o.options.boundary.offset())}catch(c){}(dpitem.offset().left<boundary.left||dpitem.offset().left+p-boundary.left>boundary.width)&&(s.addClass("flip"),dpitem.offset().left<boundary.left&&(s.removeClass("flip").addClass("stack"),p=s.css("width",s.data("single-width")).data("single-width"),r.css({"min-width":p}),o.options.centerDropdown&&s.css({"margin-left":""})));var l=parseFloat(s.height());switch(o.options.mode){case"showhide":var u={width:p,height:l};d.css(u);break;case"diagonal":var m={width:0,height:0},u={width:p,height:l};o.options.withopacity&&(m.opacity=0,u.opacity=1),d.css(m).animate(u,o.options.duration,o.options.transition);break;case"height":var m={width:p,height:0},u={height:l};o.options.withopacity&&(m.opacity=0,u.opacity=1),d.css(m).animate(u,o.options.duration,o.options.transition);break;case"width":var m={width:0,height:l},u={width:p};o.options.withopacity&&(m.opacity=0,u.opacity=1),d.css(m).animate(u,o.options.duration,o.options.transition);break;case"slide":s.css({width:p,height:l}),d.css({width:p,height:l,"margin-top":-1*l}).animate({"margin-top":0},o.options.duration,o.options.transition);break;default:var m={width:p,height:l},u={};o.options.withopacity&&(m.opacity=0,u.opacity=1),d.css(m).animate(u,o.options.duration,o.options.transition)}e={item:n,div:d,index:i}},mouseleave:function(r){return r.srcElement&&t(r.srcElement).hasClass("module")?!1:(a=!1,s.length?void window.setTimeout(function(){if(!a&&"none"!=d.css("display")){o.menu.trigger("menu:leave",[n,i]);var t=function(){n.removeClass(o.options.remainClass),e=null,d.hide().parent().hide()};if(!o.options.reverseAnimation)return void t();switch(o.options.mode){case"showhide":t();break;case"diagonal":var s={width:0,height:0};o.options.withopacity&&(s.opacity=0),d.stop().animate(s,o.options.duration,o.options.transition,function(){t()});break;case"height":var s={height:0};o.options.withopacity&&(s.opacity=0),d.stop().animate(s,o.options.duration,o.options.transition,function(){t()});break;case"width":var s={width:0};o.options.withopacity&&(s.opacity=0),d.stop().animate(s,o.options.duration,o.options.transition,function(){t()});break;case"slide":d.stop().animate({"margin-top":-1*parseFloat(d.data("dpheight"))},o.options.duration,o.options.transition,function(){t()});break;default:var s={};o.options.withopacity&&(s.opacity=0),d.stop().animate(s,o.options.duration,o.options.transition,function(){t()})}}},o.options.remainTime):void o.menu.trigger("menu:leave"))}})}),this.options.fancy){var d=t.extend({mode:"move",transition:"easeOutExpo",duration:500,onEnter:null,onLeave:null},this.options.fancy),r=this.menu.append('<div class="fancy bg1"><div class="fancy-1"><div class="fancy-2"><div class="fancy-3"></div></div></div></div>').find(".fancy:first").hide(),h=this.menu.find(".active:first"),p=null,c=function(t,i,n){i&&p&&t.get(0)==p.get(0)||(r.stop().show().css("visibility","visible"),"move"==d.mode?h.length||i?r.animate({left:t.position().left+"px",width:t.width()+"px"},d.duration,d.transition):r.hide():i?r.css({opacity:h?0:1,left:t.position().left+"px",width:t.width()+"px"}).animate({opacity:1},d.duration):r.animate({opacity:0},d.duration),p=i?t:null)};this.menu.bind({"menu:enter":function(t,i,n){c(i,!0),d.onEnter&&d.onEnter(i,n,r)},"menu:leave":function(t,i,n){c(h,!1),d.onLeave&&d.onLeave(i,n,r)},"menu:fixfancy":function(t){p&&r.stop().show().css({left:p.position().left+"px",width:p.width()+"px"})}}),h.length&&"move"==d.mode&&c(h,!0)}},matchHeight:function(){this.menu.find("li.level1.parent").each(function(){var i=0;t(this).find("ul.level2").each(function(){var n=t(this),o=n.parents(".dropdown:first").show();i=Math.max(n.height(),i),o.hide()}).css("min-height",i)})}}),t.fn[i.prototype.name]=function(){var n=arguments,o=n[0]?n[0]:null;return this.each(function(){var e=t(this);if(i.prototype[o]&&e.data(i.prototype.name)&&"initialize"!=o)e.data(i.prototype.name)[o].apply(e.data(i.prototype.name),Array.prototype.slice.call(n,1));else if(!o||t.isPlainObject(o)){var a=new i;i.prototype.initialize&&a.initialize.apply(a,t.merge([e],n)),e.data(i.prototype.name,a)}else t.error("Method "+o+" does not exist on jQuery."+i.name)})}}(jQuery);