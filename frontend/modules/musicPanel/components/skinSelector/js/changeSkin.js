$(function(){
  let margin = 0
  maximizeHeightToWindow('#skinSelector', margin); //common/assets/js/functions.js

  wp = WebPlayer.getInstance();

  $('#skinSelector').off().on('click','.skin-item', function(){
    let skin = $(this).attr('data_skin');
    wp.setSkin(skin);

    $('#skinSelectorWrapper').toggleClass('active');
    $('#showSkinPanel').toggleClass('active');
    let title = $('#skinSelectorWrapper').hasClass('active') ? Texts.getInstance().getT('closeSkinSelector') : Texts.getInstance().getT('openSkinSelector');
    $('#showSkinPanel').text(title);
  });
})
