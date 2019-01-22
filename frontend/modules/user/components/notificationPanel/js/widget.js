
$(function(){
  maximizeHeightToWindow('#notificationContainer', -20);

  let offset = $('.notifications-header').outerHeight() + $('.notifications-footer').outerHeight() + 10;
  maximizeHeight('.notifications-body', '#notificationContainer', offset);


})
