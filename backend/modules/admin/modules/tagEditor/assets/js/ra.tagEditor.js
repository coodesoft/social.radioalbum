
var TagEditor = (function(){

  function TagEditor(param){

    let self = this;

    let _history = [];

    let _domRoot = '#tagEditorNavigationArea';

    let _backButton = '#backButton';

    let _dirNav = '.directory';

    let _target = '.directory-tree';

    let _basePath = 'admin/tagEditor/';

    let _hiddenLink = '#songPath';

    let _addToHhistory = function(dir){
      _history[_history.length] = dir;
    }

    let _removeLastEntry = function(){
      if (_history.length > 0)
        _history.pop();
    }

    let _loadContent = function(data, textStatus){
      $(_target).html(data);
    }

    let _showError = function(data, textStatus){
      let modalBox = ModalBox.getInstance();
      modalBox.show("asd", data);
    }


    self.getRelativePath = function(){
      let path = '';
      if (_history.length>0){
        for (var i = 0; i < _history.length-1; i++) {
          path += _history[i] +'/';
        }
        path += _history[_history.length-1];

        let arrPath = path.split(" ");
        path = arrPath.join("+");
      }
      return path;
    }

    self.navigateToLastLocation = function(){
      let requester = Requester.getInstance();

      let url = window.location.href + '?dir=' + self.getRelativePath();
      requester.request(url, _loadContent, _showError);
    }

    self.init = function(opts){
      _history = [];

      if (opts != undefined){
        if (opts.hasOwnProperty('domRoot'))
          _domRoot = opts['domRoot'];

        if (opts.hasOwnProperty('backButton'))
          _backButton = opts['backButton'];

        if (opts.hasOwnProperty('dirNav'))
          _dirNav = opts['dirNav'];

        if (opts.hasOwnProperty('target'))
          _target = opts['target'];
      }
    };


    self.run = function(){
      let requester = Requester.getInstance();

      $(_domRoot).off().on('click', _backButton, function(){
        _removeLastEntry();
        let path = self.getRelativePath();
        let url = window.location.href + '?dir=' + path;
        requester.request(url, _loadContent, _showError);

      });

      $(_domRoot).on('click', _dirNav, function(){
        _addToHhistory($(this).text());
        let path = self.getRelativePath();
        let url = window.location.href + '?dir=' + path;
        requester.request(url, _loadContent, _showError);
      });

      $(_domRoot).on('click', '[data-crud="edit"]', function(){
        let path = self.getRelativePath();
        tags = $(this).attr('data-tags');
        song = $(this).attr('data-name')
        let url = getBackendUrl() + _basePath + 'nav/edit?song=' + song +'&tags=' + tags;

        requester.request(url,
          function(data, textStatus){
            _loadContent(data, textStatus);
            $(_hiddenLink).val(self.getRelativePath() +'/'+ song);
          }, _showError);
      });

      $(_domRoot).on('click', '#returnToLastLocation', function(){
        self.navigateToLastLocation();
      })
    }
  }

  var instance;

  return {
    getInstance: function(opts){
      if (!instance)
        instance = new TagEditor();
      return instance;
    }
  }
  })();
