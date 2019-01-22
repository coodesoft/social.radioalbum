
var Observer = (function($){

  function Observer(){

    let _noNotificationBlock = '<div class="no-notifications paragraph"></div>';

    let _container = '#notificationContainer';

    let _containerBody = '.notifications-body';

    let _footerContent;

    let _statusCheck;

    let TIME = 30000;

    /*
     * Funciones para el control interno del estado del panel
     */

    let _showNoNotificationBlock = function(){
      $(_containerBody).html(_noNotificationBlock);
      $('.no-notifications').html(Texts.getInstance().getT('noNotifications'));
    }

    let _showNotificationCounter = function(status){
      if (status == undefined || status == true)
        $('.notification-counter').show();

      if (status == false)
        $('.notification-counter').hide();
    }

    let _showFooterContentMarkAll = function(value){
      if (value == undefined || value == true)
        $('.notifications-footer').prepend(_footerContent);

      if (value == false)
        $('.notifications-footer .mark-all-read').remove();

    }

    let _setEmptyPanel = function(){
        _showNoNotificationBlock();
        _showFooterContentMarkAll(false);
    }

    let _removeNotificationFromPanel = function(element){
      $ul = $(element).closest('ul');
      $(element).closest('li').remove();
       if (!$ul.html()){
         _setEmptyPanel();
         _showNotificationCounter(false);
      }
    }

    let _setNotificationStatusCheck = function(value){
      _statusCheck = value;
    }

    let _isNotificationChecked = function(){
      return _statusCheck;
    }

    let _showNotificationPanel = function(value){
      if (value == undefined || value == true){
        $(_container).removeClass('notification-hide');
        $(_container).addClass('notification-show');
        _setNotificationStatusCheck(true);
      }

      if (value == false){
        $(_container).removeClass('notification-show');
        $(_container).addClass('notification-hide');
        _setNotificationStatusCheck(false);
      }
    }

    let _addErrorBlockToPanel = function(message){
      let alert = getAlertBox(message, 'danger');
      let li = '<li class="notification-error">'+alert+'</li>';
      if ($(_containerBody).html()){
          if ($('.notification-error').html())
            $('.notification-error').html(alert);
          else
           $(_containerBody).prepend(li);
      } else{
        $(_containerBody).html(li);
      }
    }

    let _initPanelStatus = function(){
      _footerContent = $('.notifications-footer .mark-all-read');
      _showNotificationPanel(false);
    }

    /*
     * Funciones para obtener notificaciones y estados desde el servidor
     */
    let checkCount = function(){
      let requester = Requester.getInstance();
        setTimeout(function(){

          let done = function(data, textStatus, jqXHR){
            if (data['response']>0){
              $('.notification-counter-text').text(data['response']);
              _showNotificationCounter();

              if (_isNotificationChecked())
                check();
            }
          };

          let always = function(data, textStatus, jqXHR){
            checkCount();
          };

          let error = function(data, textStatus, jqXHR){
            ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
          };;

          requester.requestJson(getFrontendUrl() + 'user/social/check-count', done, error, always);

        }, TIME);
    }

    let check = function(){
      let requester = Requester.getInstance();

      let done = function(data, textStatus, jqXHR){
        if (data.length>1){
          $('.notifications-body').html(data);
          _showFooterContentMarkAll();
        } else
          _setEmptyPanel();

      };

      let error = function(data, textStatus, jqXHR){
        ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
      };;

      requester.request(getFrontendUrl() + 'user/social/check', done, error);
    }

    /*
     * Funciones principal
     */
    let run = function(){
      _initPanelStatus();
      checkCount();

      $('body').on('click', '[data-action="social.check-notification"]', function(e){
        e.preventDefault(); e.stopPropagation();

        _showNotificationCounter(false);
        if (!_isNotificationChecked()){
          _showNotificationPanel();
          check();
        } else
          _showNotificationPanel(false);

      });

      $('body').on('click', 'a[data-action="social.response_follow"]', function(e){
        e.preventDefault(); e.stopPropagation();
        let requester = Requester.getInstance();

        let $link = this;
        let done = function(data, textStatus, jqXHR){
            _removeNotificationFromPanel($link);
            $('.aditional-data').text(data['response']);
        };

        let error = function(data, textStatus, jqXHR){
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
        };;

        requester.requestJson(this.href, done, error);
      });

      $('body').on('click', 'a[data-action="social.mark-as-read"]', function(e){
        e.preventDefault(); e.stopPropagation();

        let requester = Requester.getInstance();
        let $link = this;

        let done = function(data, textStatus, jqXHR){
          if (data['response']){
            _removeNotificationFromPanel($link);
          }
        };

        let error = function(data, textStatus, jqXHR){
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
        };

        requester.requestJson($($link).attr('href'), done, error);
      });

      $('body').on('click', 'a[data-action="social.mark-all-read"]', function(e){
        e.preventDefault(); e.stopPropagation();
        let requester = Requester.getInstance();

        let done = function(data, textStatus, jqXHR){
          if (data['response'])
            _setEmptyPanel();
          else{
            _addErrorBlockToPanel(Texts.getInstance().getT('errorMarkAllRead'));

          }
        };

        let error = function(data, textStatus, jqXHR){
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
        };

        requester.requestJson(this.href, done, error);
      });
    }

    this.init = function(){
      run();
    }
  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new Observer();
      instance.init();
      return instance;
    }
  }

})(jQuery);
