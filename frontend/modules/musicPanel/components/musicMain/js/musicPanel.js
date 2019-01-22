
$(function(){
  maximizeHeightToWindow('#musicPanel'); //common/assets/js/functions.js
  maximizeHeightToWindow('#playbackInfoWrapper');

  console.log('musicPanel');
  
  let texts = Texts.getInstance();
  $('#musicPanel').on('click', '#showSkinPanel', function(){
    $('#skinSelectorWrapper').toggleClass('active');
    $('#showSkinPanel').toggleClass('active');
    let title = $('#skinSelectorWrapper').hasClass('active') ? texts.getT('closeSkinSelector') : texts.getT('openSkinSelector');
    $(this).text(title);
  })
})
