
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
    }

    let ROTATOR_FACTOR = 0.55;

    let WpEvent = {
      'COLLECTION_ENDED': 'collection_ended',
      'SKIN_LOADED' : 'skin_loaded',
      'COLLECTION_LOADED' : 'collection_loaded',
    }

    let flags = Flags.getInstance();

    let status = Status.getInstance();

    let history = Record.getInstance();

    let visor = PlaybackVisor.getInstance();

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
      'album' : {
        'id' : '#album-art',
        'control' : {
          'next' : {'id' : '#album-next'},
          'prev' : {'id' : '#album-prev'},
        },
      },
      'channel' : {
        'id' : '#channels',
        'item': '.ch-item',
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
        'volume' : {
          'rotator' : '#volume-song',
          'bar': '#volume-song-bar',
          'barIndicator': '#volume-song-bar .indicator',
        },
      },
    };

    let volumeSkinController = {
      'type': {
        'ROTATOR' : 'rotator',
        'HORIZONTAL': 'horizontal',
        'VERTICAL': 'vertical',
      },
      'angle': 0,
      'value': 0.5,
      'controller' : {
        'rotator' : '',
        'horizontal': '',
        'vertical': '',
      },
    }

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

          visor.setArtistInfo(playbackControl.actualCollection.label.owner, {'nav': playbackControl.actualCollection.ownerUrl});
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

          $(root.audio).jPlayer('setMedia', { mp3: response['url'] });
          if (autoplay == true){
            let skin = $(root.skin.id).attr('data-webplayer');
            if (register[skin]['playback'].length)
              register[skin]['playback'](self.api);
          }

        playbackControl.actualCollection.actualSongPosition = pos;
        playbackControl.actualCollection.label.song = response['name'];

        visor.setSongInfo(playbackControl.actualCollection.label.song, {'add': response['urlAdd'], 'fav': response['urlFav']})
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


    let createVolumeControl = function(){

      /* CREA EL VOLUMEN ROTATOR*/
      volumeSkinController.controller.rotator = new Propeller(root.controls.volume.rotator, {
        inertia: 0,
        speed: 0,
        angle: 337.074,
        onRotate : function (){
          let vol = 0;

          this.angle = (this.angle>90 && this.angle<=180) ? 90 : this.angle;
          this.angle = (this.angle<270 && this.angle>180) ? 270 : this.angle;

          if (this.angle>0 && this.angle<=90)
            vol = this.angle * ROTATOR_FACTOR + 50;
            // [0 , 49.5] + 50

          if (this.angle>=270)
            vol = (this.angle - 270) * ROTATOR_FACTOR;
            // [0 , 49.5]

          vol = vol / 100;
          self.api.volume(vol);
        }
      });


      /* CREA EL VOLUMEN VERTICAL*/
      let volumeProp = playbackControl.actualVolume * 100;
      let final = $(root.controls.volume.bar).height();
      let initialPos = volumeProp*final/100 - $(root.controls.volume.barIndicator).height()/2;

      $(root.controls.volume.barIndicator).css({top: initialPos});
      $(root.controls.volume.barIndicator).draggable({
        axis: "y",
        containment: "parent",
        drag: function() {
          element = $(root.controls.volume.barIndicator);
          let salto =  100 / ($(root.controls.volume.bar).height() - element.height());
          let top = element.position().top;
          let vol =  (100-(top*salto)) / 100;

          self.api.volume(vol);
        },
      });

    }

    let updateVolumeControlSkin = function(type){
      switch (type) {
        case volumeSkinController.type.ROTATOR:
          let volume = playbackControl.actualVolume  * 100;
          volumeSkinController.controller.rotator.angle = volume>50 ? (volume-50) / ROTATOR_FACTOR : (volume/ROTATOR_FACTOR) + 270;

          break;
        case volumeSkinController.type.HORIZONTAL:

          break;
        case volumeSkinController.type.VERTICAL:
          let volumeProp = playbackControl.actualVolume * 100;
          let barHeight = $(root.controls.volume.bar).height();
          let barIndicatorHeight = $(root.controls.volume.barIndicator).height();
          let initialPos = (100-volumeProp)*barHeight/100;

          if (initialPos+barIndicatorHeight>barHeight)
            initialPos = initialPos - barIndicatorHeight;

          $(root.controls.volume.barIndicator).css({top: initialPos});
          break;
        default:

      }
    }

    let updateSkinId = function(id){
      skin = id;
    }

    let skinCssLoaded = function(link){
      link.onload = function () {
        $(root.skin.id).trigger(WpEvent.SKIN_LOADED);
        }
        // #2
        if (link.addEventListener) {
          link.addEventListener('load', function() {
            $(root.skin.id).trigger(WpEvent.SKIN_LOADED);
          }, false);
        }
        // #3
        link.onreadystatechange = function() {
          var state = link.readyState;
          if (state === 'loaded' || state === 'complete') {
            link.onreadystatechange = null;
            $(root.skin.id).trigger(WpEvent.SKIN_LOADED);
          }
        };

        // #4
        var cssnum = document.styleSheets.length;
        var ti = setInterval(function() {
          if (document.styleSheets.length > cssnum) {
            $(root.skin.id).trigger(WpEvent.SKIN_LOADED);
            clearInterval(ti);
          }
        }, 10);
    }

    self.registerCallback = function(skin, volumeType, playback, pause){
      if (!register.hasOwnProperty(skin))
        register[skin] = new Object();
        register[skin]['type'] = volumeType;
        register[skin]['playback'] = playback;
        register[skin]['pause'] = playback;
    }

    self.loadExternalSources = function(url){
      let jxhr = $.get({url: url});
      jxhr.done(function ( data, textStatus, jqXHR ){
        if (flags.SUCCESS == textStatus){
          data = JSON.parse(data);
          let response = data['response'];

          switch (response['type']) {
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
      attachJPlayer();
      history.init();
      context = ctx;
      register = new Object();
    }

    self.run = function(){
      /*
       * **** REPRODUCCIÓN DE CANCIONES
       */
      $(root.id).on('click', root.controls.play.id, function(){
        let skin = $(root.skin.id).attr('data-webplayer');
        let playCallback = register[skin]['playback'];

        if (isFunction(playCallback))
          playCallback(self.api);
      });

      $(root.id).on('click', root.controls.pause.id, function(){
        let skin = $(root.skin.id).attr('data-webplayer');
        let pauseCallback =  register[skin]['pause'];

        if (isFunction(pauseCallback))
          pauseCallback(self.api);
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
       let context = '#previewContainer';
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

      /*
       * **** AUTOMATIZACIÓN DEL PROCESO DE REPRODUCCIÓN
       */
      $(root.id).on($.jPlayer.event.ended, function(){
        nextSong();
      })

      /*
       * **** CONTROL DE LOS SKIN
       */
       $(root.id).on(WpEvent.SKIN_LOADED, root.skin.id, function(){
         let skin = $(root.skin.id).attr('data-webplayer');
         updateVolumeControlSkin(register[skin]['type']);
       });

       $(root.id).on('click', root.controls.volume.bar, function(event){
         let posY = event.clientY;
         let top = $(this).position().top;
         let height = $(this).height();

         let valuePos = (height + top) - posY;

         let volPos = valuePos * 100 / height;

         self.api.volume(volPos/100)
         updateVolumeControlSkin(volumeSkinController.type.VERTICAL);
       });
    }

    self.api = {
      play: function(){
        $(root.audio).jPlayer('play');
        visor.updateSongPlaybackStatus('play');
      },
      pause: function(){
        $(root.audio).jPlayer('pause');
        visor.updateSongPlaybackStatus('pause');
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
      dom: function(){
        let dom = root;
        return dom;
      }
    }


    self.setSkin = function(id){
      let asset = $(root.skin.id).attr('data-bundle');
      let path = getFrontendAssetsURL()+asset+"/css/mods/"+id+"_player/"+id+"_player";
      let link = '<link href="'+path+'.css" rel="stylesheet" class="dyn-wp-css">'

      $('.dyn-wp-css').remove();
      $('.dyn-wp-js').remove();

      let script = document.createElement("script");
      script.setAttribute('class', '.dyn-wp-js');
      script.src = path+'.js';

      //  $('head').append(script);
      skinCssLoaded(link);
      $('head').append(link);

      $(root.skin.id).attr('data-webplayer', id);
      $(root.skin.element).attr('style', 'background: url('+path+'.png) no-repeat;');


    if (!register.hasOwnProperty(id))
      $.getScript(path+'.js', function( data, textStatus, jqxhr ){
        createVolumeControl();
        $(root.skin.id).trigger(WpEvent.SKIN_LOADED);
      });

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
