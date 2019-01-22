
var Searcher = (function(){

  function Searcher(){

    let container = {
      'target' : '#main-container',
      'root': '#globalSearch',
      'form': '#globalSearchForm',
      'linkId': '#searcherLink',
      'iconSearch' : '#iconSearcher',
    }

    let _url;

    let _params;

    let _searchCallback = function(data){
      $(container.target).html(data)
    }

    this.init = function(){
      _url = $(container.linkId).attr('href');
      _params = null;
    }

    this.run = function(){

      $('#inputGlobalSearch').keypress(function (e) {
        if (e.which == 13 && $(this).val()!='') {
          let params = $(container.form).serialize();
          url = _url+ "?" + params;
          $(container.linkId).attr('href', url);
          $(container.linkId).click();

          e.preventDefault();
          e.stopPropagation();
        }

      });
      $(container.root).off().on('click', container.iconSearch, function(){
          let params = $(container.form).serialize();
          let value = $('#inputGlobalSearch').val();
          if (value){
            url = _url+ "?" + params;
            $(container.linkId).attr('href', url);
            $(container.linkId).click();
          }
      });
    }


  }

  var instance;

  return {
    getInstance: function(){
      if (!instance){
        instance = new Searcher();
        instance.init();
      }
      return instance;
    }
 }
})();

$(function(){
  let searcher = Searcher.getInstance();
  searcher.run();
})

/*
let widget = function(){
    let searcher = Searcher.getInstance();
    searcher.run();
}

let register = Register.getInstance();
register.addRegister('searcher', widget, '#globalSearch');
*/
