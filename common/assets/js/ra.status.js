
var Status = (function(){

  function Status(){

    this.properties = {};

    Object.defineProperties(this.properties, {
      'ACTIVE' : {
        value: 'active',
        writable: false,
        configurable: false,
      },
      'LOADED' : {
        value: 'content_loaded',
        writable: false,
        configurable: false,
      },
      'LAZY_LOADED' : {
        value: 'lazy_content_loaded',
        writable: false,
        configurable: false,
      },
      'LOADBAR_EVENT' : {
        value: 'load_bar_event',
        writable: false,
        configurable: false,
      },
      'ERRORLOADED' : {
        value: 'error',
        writable: false,
        configurable: false,
      },
      'BLOCK' : {
        value: 'ra-block',
        writable: false,
        configurable: false,
      },
      'HIDE' : {
        value: 'ra-hidden',
        writable: false,
        configurable: false,
      },
      'SUCCESS' : {
        value: 'success',
        writable: false,
        configurable: false,
      },
      'PENDING' : {
        value : '0',
        writable: false,
        configurable: false,
      },
      'ACCEPTED' : {
        value : '1',
        writable: false,
        configurable: false,
      },
      'DECLINED' : {
        value : '2',
        writable: false,
        configurable: false,
      },
      'BLOCKED' : {
        value : '3',
        writable: false,
        configurable: false,
      },
    });
  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new Status();
      return instance.properties;
    }
 }
})();
