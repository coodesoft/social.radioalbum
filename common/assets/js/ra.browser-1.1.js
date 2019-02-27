
var Browser = (function($){

  function Browser(){

      self = this;

      let options = {
        source: '',
        target: '',
        variableWrapper: '',
        modal: '',
      };

      let status;

      let flags;

      let modalBox;

      let requester;

      let texts;

      /*
       * Métodos Privados
       */

      let navigate = function(urlTarget, context, windowEvent, target){
        let done = function(data, textStatus){
          if (flags.SUCCESS == textStatus){
            $(target).html(data);
            if (!windowEvent)
              window.history.pushState({source:urlTarget, lastTrigger: context }, context, urlTarget)
            else
              window.history.replaceState({source: urlTarget, lastTrigger: context }, context, urlTarget);
            $(options.target).trigger(status.LOADED);
          }
        }
      let error = function(data, textStatus){
          $(options.target).trigger(status.ERRORLOADED);
          modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'),  '', 'danger');
        }
        requester.request(urlTarget, done, error);
      }

      let explore = function(urlTarget, target){
        let done = function(data, textStatus){
          if (flags.SUCCESS == textStatus){
            $(target).html(data);
            $(options.target).trigger(status.LOADED);
          }
        }
        let error = function(data, textStatus){
          console.log(textStatus);
          $(options.target).trigger(status.ERRORLOADED);
          modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'), '', 'danger');
        }
        requester.request(urlTarget, done, error);
      }

      let lazy_load = function(urlTarget, target, trigger){
        let done = function(data, textStatus){
            if (flags.SUCCESS == textStatus){
              response = JSON.parse(data)['response'];
              if (response['status']){
                $(trigger).parent().children('img').remove();
                $(trigger).remove();
              }
              $('[data-lazy-component="'+target+'"]').append(response['content']);
              $(trigger).attr('href', response['route']);
              $(trigger).removeClass('ra-hidden');
              $(trigger).parent().children('img').addClass('ra-hidden');
              $(options.target).trigger(status.LAZY_LOADED);
            }
        }
        let error = function(data, textStatus){
          $(options.target).trigger(status.ERRORLOADED);
          modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'), '', 'danger');
        }
        requester.request(urlTarget, done, error);
      }

      let windowNavigation = function(e){
          e.preventDefault();
          e.stopPropagation();
          $('a').removeClass(status.ACTIVE);
          let url = "";
          let lastTrigger = "";
          if (e.hasOwnProperty("state")){
            url = e.state.source;
            lastTrigger = e.state.lastTrigger;
           }
          navigate(url, lastTrigger, true, options.target);
      };


      let initComponents = function(){
        texts = Texts.getInstance();
        status = Status.getInstance();
        flags = Flags.getInstance();
        modalBox = ModalBox.getInstance();
        requester = Requester.getInstance();

      }

      /*
       * Métodos Públicos
       */

      self.init = function(opts){
        for(var i in opts)
          if (options.hasOwnProperty(i))
            options[i] = opts[i];

        initComponents();
      };

      self.run = function(){
        $(options.source).off().on('click', 'a[data-action="nav"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          $('a').removeClass(status.ACTIVE);
          $(this).addClass(status.ACTIVE);
          navigate(this.href, $(this).attr('data-context'), false, options.target);
        });

        $(options.source).on('click', 'a[data-action="explore"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          explore(this.href, options.variableWrapper);
        });

        $(options.source).on('click', 'a[data-action="modal"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          explore(this.href, options.modal);
        });

        $(options.source).on('click', 'a[data-action="lazy-load"]', function(e){
          e.preventDefault();
          e.stopPropagation();
          $(this).addClass('ra-hidden');
          $(this).parent().children('img').removeClass('ra-hidden');
          lazy_load(this.href, $(this).attr('data-lazy-target'), this);
        })

        window.removeEventListener('popstate', windowNavigation);
        window.addEventListener('popstate', windowNavigation);
      }

      self.getContext = function(){
        var cloned = $.extend(true, {}, options);
        return cloned;
      }

      self.setExplorationTarget = function(wpr){
        options.variableWrapper = wpr;
      }

      self.reNav = function(){
        navigate(window.history.state.source, 'reload_event', false, options.target);
      }

      self.reExplore = function(){
        explore(window.history.state.source, options.variableWrapper);
      }


  }

  var instance;


  return {
    getInstance: function(){
      if (!instance){
        instance = new Browser();
      }
      return instance;
    }
  }

})( jQuery);
