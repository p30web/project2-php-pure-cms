(function($){var $menu_show=$(".mobile-toggle"),$menu=$("header #menu-main"),$list=$("ul.nav-menu li a"),$menu_list=$("header li.has-dropdown"),$menu_ul=$("ul.sub-menu"),$cart_model=$(".cart-model"),$cart_link=$("#cart-link"),$search_bar=$("#search_bar"),$search_close=$(".close-search"),$search_bot=$("#search-header"),$fixed_header=$("#fixed-header"),$fixed_header_dark=$("#fixed-header-dark"),$sticky_content=$(".sticky-content"),$sticky_sidebar=$(".sticky-sidebar");$menu_show.on("click",function(e){$menu.slideToggle();});$list.on("click",function(e){var submenu=this.parentNode.getElementsByTagName("ul").item(0);if(submenu!=null){event.preventDefault();$(submenu).slideToggle();}});$cart_link.on("click",function(e){$cart_model.slideToggle("fast");});$(window).on("click",function(e){$cart_model.hide("fast");});$cart_link.on("click",function(e){event.stopPropagation();});$search_bot.on("click",function(e){$search_bar.slideToggle("fast");});$search_close.on("click",function(e){$search_bar.hide("fast");});$(document).on("click",'[data-toggle="lightbox"]',function(event){event.preventDefault();$(this).ekkoLightbox();});$(window).on("scroll",function(){if($(window).scrollTop()>=50){$fixed_header.addClass("fixed-header");$fixed_header_dark.addClass("fixed-header-dark");}else{$fixed_header.removeClass("fixed-header");$fixed_header_dark.removeClass("fixed-header-dark");}});$('a[href="#search"]').on("click",function(event){event.preventDefault();$("#search").addClass("open");$('#search > form > input[type="search"]').focus();});$("#search, #search button.close").on("click keyup",function(event){if(event.target==this||event.target.className=="close"||event.keyCode==27){$(this).removeClass("open");}});$("form").submit(function(event){event.preventDefault();return false;});}(jQuery));var TxtType=function(el,toRotate,period){this.toRotate=toRotate;this.el=el;this.loopNum=0;this.period=parseInt(period,10)||1000;this.txt="";this.tick();this.isDeleting=false;};TxtType.prototype.tick=function(){var i=this.loopNum%this.toRotate.length;var fullTxt=this.toRotate[i];if(this.isDeleting){this.txt=fullTxt.substring(0,this.txt.length-1);}else{this.txt=fullTxt.substring(0,this.txt.length+1);}this.el.innerHTML='<span class="wrap">'+this.txt+"</span>";var that=this;var delta=150-Math.random()*100;if(this.isDeleting){delta/=2;}if(!this.isDeleting&&this.txt===fullTxt){delta=this.period;this.isDeleting=true;}else{if(this.isDeleting&&this.txt===""){this.isDeleting=false;this.loopNum++;delta=500;}}setTimeout(function(){that.tick();},delta);};window.onload=function(){var elements=document.getElementsByClassName("typewrite");for(var i=0;i<elements.length;i++){var toRotate=elements[i].getAttribute("data-type");var period=elements[i].getAttribute("data-period");if(toRotate){new TxtType(elements[i],JSON.parse(toRotate),period);}}var css=document.createElement("style");css.type="text/css";css.innerHTML=".typewrite > .wrap { border-left: 0.02em solid #fff}";document.body.appendChild(css);};