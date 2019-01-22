
function _loadSkin(id){
  let asset = $('#wp_wrapper').attr('data-bundle');
  let path = getBackendAssetsURL()+asset+"/css/mods/"+id+"_player/"+id+"_player";
  let link = '<link href="'+path+'.css" rel="stylesheet" class="dyn-wp-css">'
  //let script = '<script src="'+path+'.js" class="dyn-wp-js"></script>';

  $('.dyn-wp-css').remove();
  $('.dyn-wp-js').remove();
  $('head').append(link);
  //$('body').append(script);
  $.getScript(path+'.js');

  $('.wp-skin').attr('style', 'background: url('+path+'.png) no-repeat;');
}

$(function(){
  webplayer = WebPlayer.getInstance();
  webplayer.init(Browser.getInstance().getContext().source);
  webplayer.run();
  _loadSkin('a');

})
