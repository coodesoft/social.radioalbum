
$(function(){
  let marginOffset = 10;

  maximizeHeightToWindow('#myPanel');
  $(window).resize(function(){
    $('#myPanel').css('height', ($(window).height()-$('#myPanel').position().top));
  });


  let application = Application.getInstance({app : 'frontend'});
  application.run();

  let observer = Observer.getInstance();

})
