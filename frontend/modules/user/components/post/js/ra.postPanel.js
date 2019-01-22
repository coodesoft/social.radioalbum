
var PostPanel = (function($){

  function PostPanel(){

    let _container = {
      'parent': '#centralContainer',
      'background': '#postPanelBackground',
      'post': '#newPost',
      'wall': '#postContainer',
      'album': '.post-album',
      'albumResult': '.post-album .album-result',
      'albumSearch': '.post-album .album-name',
      'albumSelection': '.post-album .selected-album',
      'showAlbum': '#showAlbumInput',
      'send': '#sendPost',
    }

    let _internalStatus;

    let _shareAlbumStatus;

    let _albums;

    let _filteredAlbums;

    let _requester;

    let _modalBox;

    let _texts;

    /*
     * Funciones asociadas a la generación de una nueva publicación. Determinan
     * cuándo se muestra la caja de publicación nueva.
     *
     */

    let _isPostBoxVisible = function(){
      return _internalStatus == true;
    }

    let _setPostBoxVisible = function(value){
      if (value == undefined || value == null)
        _internalStatus = true;

      if (value == false)
        _internalStatus = value;
    }

    let _showNewPostBox = function(){
      $(_container.post).addClass('panel-visible');
      $(_container.post).removeClass('panel-hide');


      $(_container.background).addClass('panel-visible');
      $(_container.background).removeClass('panel-hide');

      _cleanTextArea();
      _setPostBoxVisible();
    }

    let _hideNewPostBox = function(){
      $(_container.post).addClass('panel-hide');
      $(_container.post).removeClass('panel-visible');

      $(_container.background).addClass('panel-hide');
      $(_container.background).removeClass('panel-visible');

      _setPostBoxVisible(false);
    }

    let _cleanTextArea = function(){
      $(_container.post + ' textarea').val('');
    }

    /*
     *  Funciones que manejan el adjuntado de un album para compartir
     */

     let _setAlbumShareVisible = function(value){
       if (value == undefined || value == null)
         _shareAlbumStatus = true;

       if (value == false)
         _shareAlbumStatus = value;
     }

    let _showAlbumShareInput = function(){
      $(_container.album).addClass('visible');
      _setAlbumShareVisible();
    }

    let _hideAlbumShareInput = function(){
      $(_container.album).removeClass('visible');
      $(_container.albumSearch).val("");
      $(_container.albumResult).removeClass('visible');
      $(_container.albumResult).empty();

      if ($(_container.albumSelection).length){
        $(_container.albumSelection).remove();
        _showAlbumSearch();
      }

      _resetAlbumToShareId();
      _setAlbumShareVisible(false);
    }

    let _isAlbumShareVisible = function(){
      return _shareAlbumStatus == true;
    }

    let _isAlbumsEmpty = function(){
      return _albums.length == 0;
    }

    let _setAlbums = function(value){
      _albums = value;
    }

    let _filterAlbum = function(value, collection){
      let arr = _albums;
      if (collection != undefined)
        arr = collection;

       return arr.filter(_albums => _albums['name'].toLowerCase().indexOf(value.toLowerCase())!=-1);

    }

    let _showAlbumSearch = function(){
        $(_container.albumSearch).removeClass('hide');
    }

    let _hideAlbumSearch = function(){
      $(_container.albumSearch).addClass('hide');
      $(_container.albumSearch).val("");
    }

    let _hideAlbumSearchResults = function(){
      $(_container.albumResult).removeClass('visible');
      $(_container.albumResult).empty();
    }

    let _resetAlbumToShareId = function(){
        $(_container.post +' .post-actions .share-album').val("");
    }

   /*
    * MÉTODOS CALLBACKS Y AJAX REQUESTS
    */
    let loadAlbums = function(){
      let url  = getFrontendUrl() + '/album/album/albums';

      let done = function(data, textStatus, jqXHR){
        data = JSON.parse(data);
        _setAlbums(data['response']);
      }

      let error = function(data, textStatus, jqXHR){
        texts = Texts.getInstance();
        modalBox = ModalBox.getInstance();
        modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'));
      }

      Requester.getInstance().request(url, done, error);
    }

    let postCallback = function(data){
      data = JSON.parse(data);
      _hideNewPostBox();
      _hideAlbumShareInput();
      if (data['response'])
        _modalBox.show(_texts.getT('success'),_texts.getT('postSuccess'));
      else
        _modalBox.show(_texts.getT('ops'),_texts.getT('postError'));

    }

    let errorCallback = function(){
      _modalBox.show(_texts.getT('ops'),_texts.getT('errorBrowPage'));
    }

    let _sendForm = function(){
      let url = $(_container.post+" form").attr('action');
      let content = $(_container.post+" form").serialize();

      _requester.send(url, content, postCallback, errorCallback, false);
    }


    /*
     * MÉTODOS PÚBLICOS
     */
    this.init = function(opts){
      for(var i in opts)
        if (_container.hasOwnProperty(i))
          _container[i] = opts[i];

      _setPostBoxVisible(false);
      _setAlbumShareVisible(false);
      _albums = [];
      _filteredAlbums = [];
      _texts = Texts.getInstance();
      _requester = Requester.getInstance();
      _modalBox = ModalBox.getInstance();
    }


    this.run = function(){
      autosize($('textarea'));

      $('body').on('click', '#newPostBtn', function(){
        if (_isPostBoxVisible()){
          _hideNewPostBox();
        } else{
          _showNewPostBox();
        }

      });

      $('body').on('click', _container.background, function(){
        _hideNewPostBox();
        _hideAlbumShareInput();
      });

      $(_container.post).on('click', _container.showAlbum, function(){
        if (_isAlbumShareVisible()){
           _hideAlbumShareInput();
        }else{
            loadAlbums();
            _showAlbumShareInput();
        }
      });

      $(_container.post).on('keyup', _container.albumSearch, function(e){
        let charCode = (typeof e.which == "number") ? e.which : e.keyCode;
        let textInput = $(this).val();

        let resultContainer = $(_container.post+" "+_container.albumResult);
        resultContainer.empty();
        if (textInput.length){
          _filteredAlbums = _filterAlbum(textInput);
          if (_filteredAlbums.length){
            let div, content;
            $(_container.albumResult).addClass('visible');
            for (var i = 0; i < _filteredAlbums.length; i++) {
              div = document.createElement('div');
              content = document.createTextNode(_filteredAlbums[i]['name']);

              div.setAttribute('class', 'album-share');
              div.appendChild(content);
              resultContainer.append(div);
            }
          } else
          $(_container.albumResult).removeClass('visible');
        } else{
          _filteredAlbums = [];
          $(_container.albumResult).removeClass('visible');
        }

      });

      $(_container.post).on('click', _container.albumResult + ' .album-share', function(){
        let name = $(this).text();
        let filtered = _filterAlbum(name);
        _filteredAlbums = [];

        let span = document.createElement('span');
        let i = document.createElement('i');

        span.setAttribute('class', 'selected-album');
        i.setAttribute('class', 'remove-selected clickeable fas fa-times');

        span.appendChild(document.createTextNode(filtered[0]['name']));
        span.append(i);

        //oculto el input y lo vacio
        _hideAlbumSearch();

        //agrego luego de albumSearch el span con el album seleccionado
        $(_container.albumSearch).after(span);

        //oculto .album-result y lo vacio
        _hideAlbumSearchResults();


        //agrego al input del form el id del album seleccionado
        $(_container.post +' .post-actions .share-album').val(filtered[0]['id']);


      });

      $(_container.post).on('click',  _container.album + ' .selected-album .remove-selected', function(){
        $(this).closest('span').remove();
        _showAlbumSearch();
        _resetAlbumToShareId();
      });

      $(_container.post).on('click', _container.send, function(e){
        e.preventDefault();
        e.stopPropagation();
        _sendForm();
      })
    }
  }

  var instance;

  return {
    getInstance: function(opts){
      if (!instance){
        instance = new PostPanel();
        instance.init(opts);
      }
      return instance;
    }
  }

})(jQuery);

$(function(){
  let panel = PostPanel.getInstance();
  panel.run();

})
