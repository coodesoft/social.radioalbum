$(function(){
  let marginOffset = 10;

  $('#main-container').css('height', ($(window).height()-$('#main-container').position().top)-marginOffset);
  $(window).resize(function(){
    $('#main-container').css('height', ($(window).height()-$('#main-container').position().top)-marginOffset);
  });

  let application = Application.getInstance();
  application.init({app : 'backend'});
  application.run();

  let status = Status.getInstance();
  $('body').on('click', '#showSearchBox', function(){
    if ($('#searchFormContainer').hasClass(status.HIDE))
      $('#searchFormContainer').removeClass(status.HIDE);
    else
      $('#searchFormContainer').addClass(status.HIDE);
  });


})
