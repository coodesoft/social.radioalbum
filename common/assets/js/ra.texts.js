var Texts = (function(){

  function Texts(){
    let texts = [];

    let defineContext = function(){
      let path = window.location.pathname;
      let index = path.indexOf('frontend');
      if (index != -1)
        return 'frontend';
      else
        return 'backend';
    }


    this.getT = function(k){
      if (texts===[]) return this.init(this.getT(k));
      return texts[k];
    }

    let setAllT = function(T){
      texts = T;
    }

    this.init = function(callback = null){
      let context = defineContext();
      let  url = getPlatformURL() + context +'/web/ra/get-client-txt';
      let requester = Requester.getInstance();

      let done = function(data, textStatus, jqXHR){
        texts = data;
        if (callback !== null)
          callback;
      };

      let error = function(data, textStatus, jqXHR){
        ModalBox.getInstance().show(texts['ops'],texts['errorBrowPage']);
      };

      requester.requestJson(url, done, error);
    }
  }
  var instance;

  return {
    getInstance: function(){
      if (!instance){
        instance = new Texts();
        instance.init();
      }
      return instance;
    }
  }
})();
