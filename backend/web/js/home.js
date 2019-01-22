
$(function(){
  $('#main-container').css('height',($(window).height()-$('#home-page').position().top));

   $(window).resize(function(){
     $('#main-container').css('height',($(window).height()-$('#home-page').position().top));
   });
})
