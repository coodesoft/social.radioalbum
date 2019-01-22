
var MobilePlaybackVisor = (function($){

  var instance;

  function MobilePlaybackVisor(){

    let self = this;

    let context = '#mobileVisor';

    let root = {
      'album' : '#albumInfo .mobile-visor',
    }

    let links = {
      'album': {
        'nav': '.nav-album',
      },
    }

    let _setInfo = function(element, info){
      let selector = root[element];
      $(selector).html(info);
    }

    let _updateLink = function(element, action, url){
      let selector = links[element][action];
      $(selector).attr('href', url);
    }


    self.setAlbumInfo = function(info, urls){
      _setInfo('album', info);
      _updateLink('album', 'nav', urls['nav']);
    }


    self.previewAlbumInfo = function(info, active){
      _setInfo('channel', info);
      if (active)
        $(root.album).removeClass('active');
      else
        $(root.album).addClass('active');
    }

    self.updateSongPlaybackStatus = function(status){
      if (status == 'play')
        $(root.song).addClass('active');

      if (status == 'pause')
        $(root.song).removeClass('active');
    }

    self.initMobile = function(){
      maximizeWidth(context, '#centralPanel');
    }

    self.initMarquee = function(){
      $(root.album).marquee('destroy');

      $(root.album).marquee();
    }
  }

  return {
    getInstance: function(){
      if (!instance)
        instance = new MobilePlaybackVisor();
      return instance;
    }
  }

})(jQuery);
