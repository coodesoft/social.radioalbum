
var PlaybackVisor = (function($){

  var instance;

  function PlaybackVisor(){

    let self = this;

    let context = '#playbackInfoWrapper';

    let root = {
      'channel' : '#channelInfo div',
      'album' : '#albumInfo .visor',
      'artist' : '#artistInfo .visor',
      'song' : '#songInfo div',
    }

    let links = {
      'channel': {
        'nav': '.nav-channel',
      },
      'album': {
        'nav': '.nav-album',
        'add': '.add-album-collection',
        'share': '.share-album',
      },
      'artist': {
        'nav': '.nav-artist',
      },
      'song': {
        'add': '.add-song-collection',
        'fav': '.add-song-favs',
      }
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
      _updateLink('album', 'add', urls['add']);
      _updateLink('album', 'share', urls['share']);
    }

    self.setChannelInfo = function(info, urls){
      _setInfo('channel', info);
      _updateLink('channel', 'nav', urls['nav']);
    }

    self.setArtistInfo = function(info, urls){
      _setInfo('artist', info);
      _updateLink('artist', 'nav', urls['nav']);
    }

    self.setSongInfo = function(info, urls){
      _setInfo('song', info);
      _updateLink('song', 'add', urls['add']);
      _updateLink('song', 'fav', urls['fav']);
    }

    self.previewChannelInfo = function(info, active){
      _setInfo('channel', info);
      if (active)
        $(root.channel).removeClass('active');
      else
        $(root.channel).addClass('active');
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
      $(root.channel).marquee('destroy');
      $(root.album).marquee('destroy');
      $(root.artist).marquee('destroy');
      $(root.song).marquee('destroy');


      $(root.channel).marquee();
      $(root.album).marquee();
      $(root.artist).marquee();
      $(root.song).marquee();
    }
  }

  return {
    getInstance: function(){
      if (!instance)
        instance = new PlaybackVisor();
      return instance;
    }
  }

})(jQuery);
