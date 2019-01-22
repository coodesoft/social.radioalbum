

var Requester = (function($){

  function Requester(){

    let uploadBar = '.ra-uploadBar';

    this.request = function(urlTarget, success, error, always){
      let jxhr = $.get({ url: urlTarget });

      jxhr.done(function ( data, textStatus, jqXHR ){
        success(data, textStatus);
      });

      jxhr.error(function ( data, textStatus, jqXHR ){
        error(data, textStatus);
      });

      if (always)
        jxhr.always(function (data, textStatus, jqXHR){
          always(data, textStatus);
        })
    }

    this.requestJson = function(urlTarget, success, error, always){
      let jxhr = $.get({ url: urlTarget, dataType : 'json' });

      jxhr.done(function ( data, textStatus, jqXHR ){
        success(data, textStatus);
      });

      jxhr.error(function ( data, textStatus, jqXHR ){
        error(data, textStatus);
      });

      if (always)
        jxhr.always(function (data, textStatus, jqXHR){
          always(data, textStatus);
        })
    }

    this.send = function(urlTarget, content, successCallback, errorCallback, sendFile){
      $('body').addClass('ra-progress');

      let jxhr;
      if (sendFile){
        jxhr = $.ajax({
                  url : urlTarget,
                  data: content,
                  type: 'POST',
                  processData: false,
                  contentType: false,
                  xhr: function(){
                      let xhr = $.ajaxSettings.xhr() ;
                      let bar = $(uploadBar);
                      xhr.upload.onprogress = function(evt){
                        let loaded = evt.loaded/evt.total*100;
                        bar.width(loaded+"%");
                      } ;
                        // set the onload event handler
                      //xhr.upload.onload = function(){} ;
                      // return the customized object
                      return xhr ;
                  }
              });
      } else {
        jxhr = $.ajax({
                  url : urlTarget,
                  data: content,
                  type: 'POST',
               });
      }
      jxhr.done(function ( data, textStatus, jqXHR ){
        $('body').removeClass('ra-progress');
        $(uploadBar).width(0+"%");
        successCallback(data, textStatus);
      });

      jxhr.error(function ( data, textStatus, jqXHR ){
        $(uploadBar).width(0+"%");
        $('body').removeClass('ra-progress');
        errorCallback(data, textStatus);
      });
    }

  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new Requester();
      return instance;
    }
  }
})(jQuery);
