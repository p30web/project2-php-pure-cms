
$(document).ready(function(){


  

  setInterval(function(){
    $('.arrow').toggleClass('active');
  },1000);

  $('.arrow').on('click',function(){
    var items = $('#items').offset().top;

    $('html,body').animate({
      'scrollTop' : items
    },1000)

  });

  $(window).load(function(){
    window.sr = new scrollReveal();
  });

  $(window).scroll(function(){
    var items = $('#items,.list_item').offset().top;
    var scroll = $(window).scrollTop();

    if( scroll >= items) {
      $('nav').css({
        'top': 0
      });
    }
    else {
      $('nav').css({
        'top': -85
      });
    }
  });
  $('.modal').on('show.bs.modal', function (e) {
    if (typeof (e.relatedTarget) != "undefined") {
      window.location.hash = $(e.relatedTarget).attr('href');
    }
  });
});

$(window).on('popstate', function() {
  $(".modal").modal('hide');
});