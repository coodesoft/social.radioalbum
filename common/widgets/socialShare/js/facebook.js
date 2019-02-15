


var Facebook = (function(){

  function Facebook(){


    this.run = function(){

      $('html').on('click', '[data-action="share.facebook"]', function(){
        let modal = Browser.getInstance().getContext().modal;
        $(modal).empty();
        FB.ui({
          method: 'share_open_graph',
          action_type: 'og.shares',
          action_properties: JSON.stringify({
            object: {
                       'og:url': $(this).attr('data-share-url'),
                       'og:title': $(this).attr('data-share-title'),
                       'og:image': $(this).attr('data-share-image')
                   }
          }),
        }, function(response){});
      });
    }


  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new Facebook();
      return instance;
    }
 }
})();

$(function(){
  let fb = Facebook.getInstance();
  fb.run();
})
