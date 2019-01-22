
var MainPanel = (function(){

  function MainPanel(){

    let container = {
      'root' : '#myPanel',
      'searchBox' : '.global-search',
      'closeSearchBox': '.close-searchBox',
    };

    let _isSearchBoxVisible = false;

    let _setSearchBoxVisible = function(value){
      _isSearchBoxVisible = (value == undefined || value) ? true : false;
    }

    let _showSearchBox = function(value){
      if (value == undefined || value){
        _setSearchBoxVisible();
        $(container.searchBox).addClass('active');
        $(container.searchBox).removeClass('initial');
      } else{
        $(container.searchBox).addClass('initial');
        $(container.searchBox).removeClass('active');
        _setSearchBoxVisible(false);
      }
    }

    this.run = function(){
      $(container.root).off().on('click', container.searchBox+" input", function(){
        console.log('search box');
        if (!_isSearchBoxVisible){
          _showSearchBox();
        }
      });

      $(container.root).on('click', container.closeSearchBox, function(){
        if (_isSearchBoxVisible)
          _showSearchBox(false);
      });
    }


  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new MainPanel();
      return instance;
    }
 }
})();


$(function(){
    let mainPanel = MainPanel.getInstance();
    mainPanel.run();
})


$(window).resize(function(){
  maximizeHeightToWindow('.ra-panel');
});
