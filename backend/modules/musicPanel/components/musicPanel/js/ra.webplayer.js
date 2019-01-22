
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

    let WpEvent = {
      'COLLECTION_ENDED': 'collection_ended',
      'CHANNEL_ENDED':  'channel_ended'
    }

    let flags = Flags.getInstance();

    let status = Status.getInstance();

    let history = Record.getInstance();

    let basePath = 'backend/web/';

    let moduleName = 'webplayer/';

    /* @root: Estructura de identificadores del arbol DOM del
     * reproductor
     */
    let root = {
      'id' : '#webPlayer',
      'audio': '#wp_audio',
      'album' : {
        'id' : '#album-art',
        'info' : '#playback-info',
        'control' : {
          'next' : {'id' : '#album-next'},
          'prev' : {'id' : '#album-prev'},
        },
      },
      'channel' : {
        'id' : '#channels',
        'item': '.ch-item',
        'info' : '#channel-info',
        'control' :{
            'next' : {'id' : '#channel-next'},
            'prev' : {'id' : '#channel-prev'},
          },
      },
      'controls' : {
        'play' : {'id' : '#play-song'},
        'pause' : {'id' : '#pause-song'},
        'prev' : {'id' : '#prev-song'},
        'next' : {'id' : '#next-song'},
        'volume' : {'id' : '#volume-song'},
      },
    };

    /* @defaultChannel: es el canal que se carga para reproducir
     * por defecto
     */
    let defaultChannel = 'Rock';

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
      playbackControl.actualCollection.id = data['id'];
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
          let size = response.length;
          let items = document.createElement('ul');
          let first;

          for (var id in response) {
            if (response.hasOwnProperty(id)) {
              let li = document.createElement('li');
              li.setAttribute('id', id);
              let item = root.channel.item.substring(1);
              if (response[id] == defaultChannel){
                li.setAttribute('class', item + ' ' +status.ACTIVE);
                first = li;
              }else{
                li.setAttribute('class', item);
                items.append(li);
              }
            }
          }
          items.insertBefore(first, items.childNodes[0]);
          $(root.channel.id).html(items);
          $(root.channel.info+' span').html(defaultChannel);
          loadAlbums(first.id);
        }
      })
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
    let loadAlbums = function(id){
        let url = getActionRoute('albums', {'id' : id});
        let jxhr = $.get({url: url});
        jxhr.done(function ( data, textStatus, jqXHR ){
          if (flags.SUCCESS == textStatus){
            data = JSON.parse(data);
            let response = data['response'];
            playbackControl.actualChannel = {};
            playbackControl.actualChannel.info = {
              'id'   : response['channel']['id'],
              'name' : response['channel']['name'],
            };
            // response['albums'] contiene elementos del tipo
            // {id: someId, status: 0}
            playbackControl.actualChannel.albums = response['albums'];

            id = getIdNextAlbum();
            loadMediaCollection(collectionType.ALBUM, id, 0);
            loadSingleAlbumArt(id);
            history.addEntry(id);
          }
        })
    }

    /* @loadMediaCollection: carga las canciones de un álbum o una playlist y
     * asigna, para su reproducción, a la cancion ubicada en la posicion
     * @position
     */
    let loadMediaCollection = function(action, id, position){
      let url = getActionRoute(action, {'id' : id});
      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          data = JSON.parse(data);
          fillPlaybackControlArray(data['response'], action);
          assignSong(playbackControl.actualCollection.songs[position]['id'], position, true);
        }
      })
    }

    /* @loadSingleAlbumArt: carga desde el servidor la tapa del album definido
     * por el id pasado por parametro.
     */
    let loadSingleAlbumArt = function(id){
      let url = getActionRoute('album-art', {'id' : id});
      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          let img = document.querySelector( "#album-art img" );
              img.src = 'data:image/jpeg;base64,'+data;
        }
      })
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
          if (autoplay == true){
            $(root.audio).jPlayer('setMedia', { mp3: response['url'] });
            if (isFunction(pauseCallback))
              pauseCallback(root.controls.pause.id, self.api)
/*
            if (isFunction(playCallback))
              playCallback(root.controls.play.id, self.api);
*/
          }
          else
            $(root.audio).jPlayer('setMedia', { mp3: response['url'] });
        playbackControl.actualCollection.actualSongPosition = pos;
        playbackControl.actualCollection.label.song = response['name'];
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
          loadSingleAlbumArt(id);
          history.addEntry(id);
        } else
          $(root.audio).trigger(WpEvent.CHANNEL_ENDED);
      } else{
        history.forward();
        id = history.actualEntry();
        loadMediaCollection(collectionType.ALBUM, id, 0);
        loadSingleAlbumArt(id);
      }
    }

    let prevCollection = function(){
      if (!history.isFirst()){
        history.backward();
        id = history.actualEntry();
        loadMediaCollection(collectionType.ALBUM, id, 0);
        loadSingleAlbumArt(id);
      }
    }

    self.registerPlayCallback = function(callback){
      playCallback = callback;
    }

    self.registerPauseCallback = function(callback){
        pauseCallback = callback;
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
              loadSingleAlbumArt(response['collection_id']);
              break;
            case collectionType.PLAYLIST:
              loadMediaCollection(collectionType.PLAYLIST, response['collection_id'], response['song_position']);
              let img = document.querySelector( "#album-art img" );
              img.src = getPlatformURL() + basePath + 'img/art-back-alt-1.png';
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
    }

    self.run = function(){

      /*
       * **** REPRODUCCIÓN DE CANCIONES
       */
      $(root.id).on('click', root.controls.play.id, function(){
        if (isFunction(playCallback))
          playCallback(this, self.api);
      });

      $(root.id).on('click', root.controls.pause.id, function(){
        if (isFunction(pauseCallback))
          pauseCallback(this, root.audio);
      });

      $(root.id).on('click', root.controls.next.id, function(){
        nextSong();
      });

      $(root.id).on('click', root.controls.prev.id, function(){
        prevSong();
      });

      /*
       * **** SELECCION DE ÁLBUMES
       */
      $(root.id).on('click', root.album.control.next.id, function(){
        nextCollection();
      });

      $(root.id).on('click', root.album.control.prev.id, function(){
        prevCollection();
      });

      /*
       * **** SELECCION DE CANALES
       */
      $(root.id).on('click', root.channel.control.next.id, function(){
        let first = $(root.channel.item).filter(':first');
        first.fadeOut(200, function(){
          first.appendTo($(root.channel.item).parent()).fadeIn(200);
        });
      });

      $(root.id).on('click', root.channel.control.prev.id, function(){
        let last = $(root.channel.item).filter(':last');
          last.fadeOut(200, function(){
            last.prependTo($(root.channel.item).parent()).fadeIn(200);
          });
      })

      $(root.id).on('click', root.channel.item, function(){
        id = this.id;
        $(this).siblings().removeClass(status.ACTIVE);
        $(this).addClass(status.ACTIVE);
        loadAlbums(id);
        history.reset();
      })

      $(root.id).on('mouseenter', root.channel.item, function(){
        let name = playbackControl.channels[this.id];
        $(root.channel.info + ' span').html(name);
      })

      $(root.id).on('mouseleave', root.channel.item, function(){
          $(root.channel.info + ' span').html(playbackControl.actualChannel.info.name);
      })

      /*
       * **** CARGA Y REPRODUCCIÓN DE MUSICA ALEATORIA
       */
      $(context).on('click', 'a[data-action="playback"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          self.loadExternalSources(this.href);
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
          alert('terminó la playlist');
        }
      });

      $(root.id).on(WpEvent.CHANNEL_ENDED, root.audio, function(){
        alert('terminó el canal');
      })
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
