
var FormProcessor = (function($){

  function FormProcessor(){

      self = this;

      let callback = undefined;

      let requester;

      let options = {
        source: 'html',
        target: '#main-container',
        variableWrapper: '.ra-container',
        modal: '#ra-modalBox',
      };

      let flags = Flags.getInstance();
      let texts = Texts.getInstance();
      let modalBox = ModalBox.getInstance();

      self.configure = function(opts){
        for(var i in opts)
          if (options.hasOwnProperty(i))
            options[i] = opts[i];

        requester = Requester.getInstance();
      };


      self.setCallback = function(newCallback){
        if ((newCallback != undefined) || (newCallback != null))
          callback = newCallback;
      }

      self.resetCallback = function(){
        callback = undefined;
      }

      self.run = function(){
        if (options.source && options.target){
          $(options.source).on('submit', 'form', function(e){
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('action');
            let formData = null;
            let sendFile = false;

            if ($(this).attr('data-content')) {
              let form = $(this)[0];
              formData = new FormData(form);
              sendFile = true;
            }else{
              formData = $(this).serialize();
            }
            let done = function ( data, textStatus, jqXHR ){
              if (flags.SUCCESS == textStatus)
                if (callback != undefined)
                  callback(data);
                else
                    $(options.target).html(data);
            };

            let error = function ( data, textStatus, jqXHR){
              if (data.status != 302) {
                modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'), '', 'danger');
              }
            };
            requester.send(url, formData, done, error, sendFile);
          })
        } else
          console.log('No hay definido ningun contexto de ejecución');
      }

  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new FormProcessor();
      return instance;
    }
  }

})(jQuery);
