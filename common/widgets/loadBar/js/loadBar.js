var LoadBar = (function(){

  function LoadBar(){


    let _totalEvents = null;

    let _loadEvents;

    let _widthUnit;

    let _progressWidth;

    let _loadBarWidth;

    let _dynTemporaryCounter;

    let _loadBar = '#loadBar';

    let _progress = '#progress';


    let _updateProgress = function(){
      _progressWidth = _progressWidth + _widthUnit + 5;

      //if ( $(_progress).width() > $(_loadBar).width() ){
      if (_eventsComplete()){
        _progressWidth = 0;
        $(_progress).width(0);
      } else
        $(_progress).width(_progressWidth);
    }

    let _eventsComplete = function(){
      return (_totalEvents == _loadEvents);
    }

    let _incEventsLoadCounter = function(){
      _loadEvents = _loadEvents + 1;
    }

    let _resetEventsLoadCounter = function(){
      _loadEvents = 0;
    }

    let _registerEvent = function(){
      if (!_eventsComplete())
        _incEventsLoadCounter();
      else
        _resetEventsLoadCounter();
    }

    this.init = function(){
        _loadEvents = 0;
        _progressWidth = 0;
        _loadBarWidth = parseInt($(_loadBar).width());
        _totalEvents = null;
    }

    this.setTotalEvents = function(value){
      _totalEvents = value;
      _widthUnit = _loadBarWidth / _totalEvents;
    }

    this.resetDynEvents = function(){
      _loadEvents = 0;
      _progressWidth = 0;
    }

    this.setDynTotalEvents = function(newTotal){

      if (_totalEvents == null || newTotal < _dynTemporaryCounter){
        _totalEvents = newTotal;
        _dynTemporaryCounter = newTotal;
      }else{
        _totalEvents = newTotal - _dynTemporaryCounter;
        _dynTemporaryCounter = newTotal;
      }

      _widthUnit = _loadBarWidth / _totalEvents;
    }

    this.load = function(element){
      _updateProgress();
      _registerEvent();
    //  console.clear();
      console.log('\n'+$(element).text());
      console.log('dyn: '+_dynTemporaryCounter);
      console.log('total Events: '+_totalEvents);
      console.log('loaded Events: '+_loadEvents);
      console.log('Bar width: '+_loadBarWidth);
      console.log('Progress width: '+_progressWidth);
    }

  }
  var instance;

  return {
    getInstance: function(){
      if (!instance){
        instance = new LoadBar();
        instance.init();
      }
      return instance;
    }
  }
})();
