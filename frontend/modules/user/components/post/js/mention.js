
var Mention = (function($){

  function Mention(){

    let _regexp;

    let _requester;

    let extractMention = funntion(input){
      let mentions = _regexp.exec(input);

      let done = function(data, textStatus, jqXHR){
          data = JSON.parse(data);
          let container = data['uid_entity'];

      }

      let error = function(data, textStatus, jqXHR){
        let modalBox = ModalBox.getInstance();
        let texts = Texts.getInstance();
        modalBox.show(texts.getT('ops'), texts.getT('postError'));
      }
    }

    let userMention = function(){

      $('body').on('keypress', '#postContainer form .text_box', function(e){
        let charCode = (typeof e.which == "number") ? e.which : e.keyCode;
        let textInput = $(this).val();

        if (charCode != 13){
          let mentions = _regexp.exec(textInput);
        }
      });

      $('body').on('keypress', '#postPanel .post-content textarea', function(e){
        let charCode = (typeof e.which == "number") ? e.which : e.keyCode;
        let textInput = $(this).val();

        if (charCode != 13){
          let mentions = extractMention(textInput);
        }
      });
    }


    this.init = function(){
      _regexp = new RegExp('@[0-9a-zA-Z]+','g');
      _requester = Requester.getInstance();

    }

    this.run = function(){
      userMention();
    }


  }

  var instance;

  return {
    getInstance: function(){
      if (!instance){
        instance = new Mention();
        instance.init();
      }
      return instance;
    }
  }

})(jQuery);
