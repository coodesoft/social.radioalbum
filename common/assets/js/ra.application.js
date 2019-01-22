
var Application = (function($){

  function App(){

    let wrapper;

    let marginOffset = 10;

    let application;

    let defaults = {
        source: 'html',
        target: '#main-container',
        variableWrapper: '.ra-container',
        dynWrapper: '.ra-container',
        modal: '#ra-modalBox',
    };

    let browser;

    let status;

    let formProcessor;

    let register;

    let modalBox;

    let setApp = function(params){
      if ((params != undefined) && (params['app'] != undefined))
        application = params['app'];
      else
        application = 'frontend';
    }

    let initComponents = function(){
      status = Status.getInstance();
      flags = Flags.getInstance();

      requester = Requester.getInstance();
      modalBox = ModalBox.getInstance();
      Texts.getInstance();

      browser = Browser.getInstance();
      formProcessor = FormProcessor.getInstance();
      register = Register.getInstance();
    }


    this.init = function(params){
      setApp(params);
      initComponents();

      browser.init(defaults);
      formProcessor.configure(defaults);
      if (params != undefined){
        browser.init(params);
        formProcessor.configure(params);
      }
      modalBox.createContainer(getIdSelectorValue(defaults.modal));
    }

    this.getApp = function(){
      return application;
    }

    this.run = function(){
      browser.run();
      formProcessor.run();

      let brContext = browser.getContext();

      $(window).on(status.LOADED, function(){
        register.run();
      });

      $(window).on(status.LAZY_LOADED, function(){
        register.run();
      });

      $(defaults.source).on('click', 'button.ra-close-modal', function(){
        $(brContext.modal).empty();
      })

      $(document).keyup(function(event){
              if(event.which==27)
                if ($(brContext.modal).length>0)
                    $(brContext.modal).empty();

      });

      $(brContext.target).trigger(status.LOADED);
    }
  }

  var instance;

  return {
    getInstance: function(params){
      if (!instance){
        instance = new App();
        instance.init(params);
      }
      return instance;
    }
  }

})( jQuery );
