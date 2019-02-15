
var WebPlayer = (function($){

  var instance;

  function WebPlayer(){

    let self = this;

    /* @context: contexto de ejecución.
     * En este caso recibe el valor : 'html'
     */
    let context;

    /* @collectionType: es un objeto de control. Tiene el fin
     * de evitar la utilización de strings puros como valores de condición
     * en funciones
     */
    let collectionType = {
      'PLAYLIST' : 'playlist',
      'ALBUM': 'album',
    }

    let ROTATOR_FACTOR = 0.55;

    let WpEvent = {
      'COLLECTION_ENDED': 'collection_ended',
      'CHANNEL_ENDED':  'channel_ended',
      'COLLECTION_LOADED' : 'collection_loaded',
    }

    let flags = Flags.getInstance();

    let status = Status.getInstance();

    let history = Record.getInstance();

    let visor = MobilePlaybackVisor.getInstance();

    let basePath = 'frontend/web/';

    let moduleName = 'webplayer/';

    /* @root: Estructura de identificadores del arbol DOM del
     * reproductor
     */
    let root = {
      'id' : '#webPlayer',
      'skin': {
        'id': '#wp_wrapper',
        'element' : '.wp-skin',
      },
      'audio': '#wp_audio',
      'controls' : {
        'play' : {'id' : '#play-song'},
        'pause' : {'id' : '#pause-song'},
        'prev' : {'id' : '#prev-song'},
        'next' : {'id' : '#next-song'},
        'volume' : { 'id' : '#volumeControl' },
      },
    };

    let register;

    let skin;
    /* @defaultChannel: es el canal que se carga para reproducir
     * por defecto
     */
    let defaultChannel = 'Nuevos';

    /* @playbackControl: es el arreglo contenedor de la información
     * necesaria para controlar la reproducción(play, pause, next, prev)
     * de canciones, álbumes, playlists.
     *
     * La estructura interna quedara definida de la siguiente manera:
     * playbackControl{
     *    actualSongPosition: ...
     *    actualVolume: ...
     *    actualCollection: {
     *      label:{
     *         song: ...
     *         collection: ...
     *      }
     *      id: ...
     *      songs: { ... }
     *    }
     *    actualChannel:{
     *      info: ...
     *      albums: { ... }
     *    }
     *    channels: {...}
     *  }
     */
    let playbackControl = {};

    /* @playCallback: es la referencia que se asignara a la funcion
     * de cada skin encargada de controlar el funcionamiento estético
     * del boton de play.
     */
    let playCallback;

    /* @pauseCallback: es la referencia que se asignara a la funcion
     * de cada skin encargada de controlar el funcionamiento estético
     * del boton de pausa
     *
     * Es necesario definir esta referencia, asi como @playCallback debido
     * a que son los únicos controles que varian entre los distintos mods
     * visuales. Hay mods que solo contienen el boton de play por lo que el
     * mismo debe tomar un rol doble.
     */
    let pauseCallback;

    /* @getActionRoute: arma la url para la petición al servidor a partir
     * de una acción(@action) y un arreglo de parametros(del tipo [key:value])
     */
    let getActionRoute = function(action, params){
      let route = getPlatformURL() + basePath + moduleName + action;
      if ((params === null) || (params === undefined))
        return route;

      route += '?';
      for (var key in params)
        if (params.hasOwnProperty(key))
          route += key +'='+ params[key] + '&';

      return route;
    }

    /* @attachJPlayer: assigna el objeto jPlayer al root de la estructura
     * DOM del webplayer.
     */
    let attachJPlayer = function(){
      playbackControl.mute = false;
      playbackControl.actualVolume = 0.5;
      $(root.audio).jPlayer({
        swfPath: "/js/jplayer",
        volume:	playbackControl.actualVolume,
      });
    }

    /* @fillPlaybackControlArray: crea en @playbackControl las estructuras
     * internas basicas y necesarias para un correcto control y le asigna
     * la información pasada por parametro.
     */
    let fillPlaybackControlArray = function(data, type){
      playbackControl.actualCollection = {};
      playbackControl.actualCollection.label = {};
      playbackControl.actualCollection.label.collection = data['name'];
      playbackControl.actualCollection.label.owner = data['artist'];
      playbackControl.actualCollection.urlView = data['urlView'];
      playbackControl.actualCollection.urlAdd = data['urlAdd'];
      playbackControl.actualCollection.urlShare = data['urlShare'];
      playbackControl.actualCollection.id = data['id'];
      playbackControl.actualCollection.ownerUrl = data['urlArtistView'];
      playbackControl.actualCollection.songs = data['songs'];
      playbackControl.actualCollection.type = type;
    }

    /* @filterReproducedAlbumsIndex: filtra todos los álbumes que no han
     * sido reproducidos(con 'status'!=0) y los retorna en un arreglo
     */
    let filterReproducedAlbumsIndex = function(collection){
      filtered = [];
      for (var i = 0; i < collection.length; i++) {
        if (collection[i]['status'] != 1)
          filtered.push(i);
      }
      return filtered;
    }

    /* @loadChannels: obtiene el listado de canales del servidor y crea
     * una lista no ordenada con la información a mostrar necesaria.
     * Luego de cargar los canales utiliza @defaultChannel para cargar
     * los álbumes asociados en pos de preparar todo para la reproducción
     */
    let loadChannels = function(){
      let url = getActionRoute('channels');
      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          data = JSON.parse(data);
          let response = data['response'];
          playbackControl.channels = response;

          for (var id in response)
            if (response.hasOwnProperty(id) && response[id]['name'] == defaultChannel) {
                first = id;
                break;
            }

          loadAlbums(first);
        }
      });
    }

    /* @getIdNextAlbum : a partir de los ids disponibles para su reproducción
     * que retorna @filterReproducedAlbumsIndex, realiza un random sobre los mismos
     * y retorna el id correspondiente.
     * Si no tiene ids disponibles para reproducir retorna -1;
     */
    let getIdNextAlbum = function(){
      filteredIds = filterReproducedAlbumsIndex(playbackControl.actualChannel.albums);

      if (filteredIds.length == 0)
        return -1;

      let albumToPlay = randomize(0, filteredIds.length);
      playbackControl.actualChannel.albums[filteredIds[albumToPlay]].status = 1;

      return playbackControl.actualChannel.albums[filteredIds[albumToPlay]].id;
    }

    /* @loadAlbums: obtiene un arreglo con los "id" de los álbumes asociados
     * al canal cuyo id se pasa por parametro.
     * Realiza un random sobre los indices de ese arreglo para determinar el
     * album, y su correspondiente, tapa a cargarse.
     */
    let loadAlbums = function(id, external){
        let url = (external == null) ? getActionRoute('albums', {'id' : id}) : id;
        let jxhr = $.get({url: url});
        jxhr.done(function ( data, textStatus, jqXHR ){
          if (flags.SUCCESS == textStatus){
            data = JSON.parse(data);
            let response = data['response'];
            playbackControl.actualChannel = {};
            playbackControl.actualChannel.info = {
              'id'   : response['channel']['id'],
              'name' : response['channel']['name'],
              'urlView'  : response['channel']['urlView'],
            };
            // response['albums'] contiene elementos del tipo
            // {id: someId, status: 0}
            playbackControl.actualChannel.albums = response['albums'];

            id = getIdNextAlbum();
            loadMediaCollection(collectionType.ALBUM, id, 0);
            history.addEntry(id);

            if (external)
              visor.setChannelInfo(playbackControl.actualChannel.info.name, {'nav' : playbackControl.actualChannel.info.urlView });
          }
        })
    }

    /* @loadMediaCollection: carga las canciones de un álbum o una playlist y
     * asigna, para su reproducción, a la cancion ubicada en la posicion
     * @position
     */
    let loadMediaCollection = function(action, id, position){
      let url
      if (id != null)
        url = getActionRoute(action, {'id' : id});
      else
        url = action;

      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          data = JSON.parse(data);
          fillPlaybackControlArray(data['response'], action);
          visor.setAlbumInfo(playbackControl.actualCollection.label.collection, { 'nav': playbackControl.actualCollection.urlView,
                                                                                  'add': playbackControl.actualCollection.urlAdd,
                                                                                  'share': playbackControl.actualCollection.urlShare
                                                                                });

          assignSong(playbackControl.actualCollection.songs[position]['id'], position, true);
          $(root.audio).trigger(WpEvent.COLLECTION_LOADED);
        }
      });
    }

    /* @assignSong: asigna al objeto reproductor la cancion correspondiente
     */
    let assignSong = function(id, pos, autoplay){
      let url = getActionRoute('song', {'id' : id});
      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          data = JSON.parse(data);
          let response = data['response'];

          $(root.audio).jPlayer('setMedia', { mp3: response['url'] }).jPlayer('play');

        playbackControl.actualCollection.actualSongPosition = pos;
        playbackControl.actualCollection.label.song = response['name'];

        visor.initMarquee();
        }
      });
    }

    let nextSong = function(){
      actualPosition = playbackControl.actualCollection.actualSongPosition;
      if (actualPosition < playbackControl.actualCollection.songs.length-1){
        playbackControl.actualCollection.actualSongPosition = actualPosition + 1;
        let id = playbackControl.actualCollection.songs[playbackControl.actualCollection.actualSongPosition]['id'];
        assignSong(id, playbackControl.actualCollection.actualSongPosition, true);
      } else{
        $(root.audio).trigger(WpEvent.COLLECTION_ENDED);
      }

    }

    let prevSong = function(){
      actualPosition = playbackControl.actualCollection.actualSongPosition;
      if (actualPosition > 0){
        playbackControl.actualCollection.actualSongPosition = actualPosition - 1;
        let id = playbackControl.actualCollection.songs[playbackControl.actualCollection.actualSongPosition]['id'];
        assignSong(id, playbackControl.actualCollection.actualSongPosition, true);
      }
    }

    let nextCollection = function(){
      if (history.isLast()){
        id = getIdNextAlbum();
        if (id>0){
          loadMediaCollection(collectionType.ALBUM, id, 0);
          history.addEntry(id);
        } else
          $(root.audio).trigger(WpEvent.CHANNEL_ENDED);
      } else{
        history.forward();
        id = history.actualEntry();
        loadMediaCollection(collectionType.ALBUM, id, 0);
      }
    }

    let prevCollection = function(){
      if (!history.isFirst()){
        history.backward();
        id = history.actualEntry();
        loadMediaCollection(collectionType.ALBUM, id, 0);
      }
    }

    self.loadExternalSources = function(url){
      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          data = JSON.parse(data);
          let response = data['response'];

          switch (response['type']) {
            case collectionType.ALBUM:
              loadMediaCollection(collectionType.ALBUM, response['collection_id'], response['song_position']);
              break;
            case collectionType.PLAYLIST:
              loadMediaCollection(collectionType.PLAYLIST, response['collection_id'], response['song_position']);
              break;
            default:
              alert('collection type unknowun');
          }
        }
      });
    }

    self.init = function(ctx){
      loadChannels();
      attachJPlayer();
      history.init();
      context = ctx;
      register = new Object();
    }

    self.run = function(){
      visor.initMobile();
    /*
       * **** REPRODUCCIÓN DE CANCIONES
       */
      $(root.id).on('click', root.controls.play.id, function(){
        if (self.api.status().paused){
          self.api.play();
          if ($(root.controls.play.id+" .pause-display").hasClass('ra-hidden'))
            $(root.controls.play.id+" .pause-display").removeClass('ra-hidden');

          if (!$(root.controls.play.id+" .play-display").hasClass('ra-hidden'))
            $(root.controls.play.id+" .play-display").addClass('ra-hidden');
        } else{
          self.api.pause();
          if (!$(root.controls.play.id+" .pause-display").hasClass('ra-hidden'))
            $(root.controls.play.id+" .pause-display").addClass('ra-hidden');

          if ($(root.controls.play.id+" .play-display").hasClass('ra-hidden'))
            $(root.controls.play.id+" .play-display").removeClass('ra-hidden');
        }

      });

      $(root.id).on('click', root.controls.next.id, function(){
        nextSong();
      });

      $(root.id).on('click', root.controls.prev.id, function(){
        prevSong();
      });

      /*
       * **** CARGA Y REPRODUCCIÓN DE MUSICA ALEATORIA
       */
      $(context).on('click', 'a[data-action="playback"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          self.loadExternalSources(this.href);
      });

      $(context).on('click', 'a[data-action="playback-collection"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          loadMediaCollection(this.href, null, 0);
      });

      $(context).on('click', 'a[data-action="playback-channel"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          loadAlbums(this.href, true);
      });

      /*
       * **** AUTOMATIZACIÓN DEL PROCESO DE REPRODUCCIÓN
       */
      $(root.id).on($.jPlayer.event.ended, function(){
        nextSong();
      })

      $(root.id).on(WpEvent.COLLECTION_ENDED, root.audio, function(){
        if (playbackControl.actualCollection.type == collectionType.ALBUM){
          nextCollection();
        } else {
          alert('Hey! Llegaste al final de la colección.');
        }
      });

      $(root.id).on(WpEvent.CHANNEL_ENDED, root.audio, function(){
        alert('Hey! Llegaste al final del canal.');
      });

       // Seguro hay una mejor forma de actualizar los iconos
       $(root.id).on('click', root.controls.volume.id, function(event){
         if (playbackControl.mute == false){
           self.api.mute(true);
           if ($(root.controls.volume.id+" .volume-on").hasClass('ra-hidden'))
              $(root.controls.volume.id+" .volume-on").removeClass('ra-hidden')

           if (!$(root.controls.volume.id+" .volume-mute").hasClass('ra-hidden'))
              $(root.controls.volume.id+" .volume-mute").addClass('ra-hidden')

         }else {
            self.api.mute(false);
            if (!$(root.controls.volume.id+" .volume-on").hasClass('ra-hidden'))
               $(root.controls.volume.id+" .volume-on").addClass('ra-hidden')

            if ($(root.controls.volume.id+" .volume-mute").hasClass('ra-hidden'))
               $(root.controls.volume.id+" .volume-mute").removeClass('ra-hidden')
          }
       });
    }

    self.api = {
      play: function(){
        $(root.audio).jPlayer('play');
      },
      pause: function(){
        $(root.audio).jPlayer('pause');
      },
      status: function(){
        let jp = $(root.audio), jpData = jp.data('jPlayer');
        return jpData.status;
      },
      mute: function(status){
        if (status){
          $(root.audio).jPlayer('mute');
          playbackControl.mute = true;
        }else{
          $(root.audio).jPlayer('unmute');
          playbackControl.mute = false;
        }

      },
      volume: function(volume){
        if (volume){
          playbackControl.actualVolume = volume;
          $(root.audio).jPlayer('volume', playbackControl.actualVolume);
        }
        return playbackControl.actualVolume;
      },

      actualSongLabel: function(){
        return playbackControl.actualCollection.label.song;
      },
      actualCollectionLabel : function(){
          return playbackControl.actualCollection.label.collection;
      },
      dom: function(){
        let dom = root;
        return dom;
      }
    }

  }

  return {
    getInstance: function(){
      if (!instance)
        instance = new WebPlayer();
      return instance;
    }
  }

})(jQuery);
