
var Record = (function($){

  var instance;

  function Record(){

    let self = this;

    let entries = [];

    let pointer;

    self.init = function(){
      pointer = -1;
    }

    self.addEntry = function(entry){
      entries.push(entry);
      pointer = pointer + 1;
    }

    self.reset = function(){
      entries = [];
      pointer = -1;
    }

    self.actualEntry = function(){
      return entries[pointer];
    }

    self.lastEntry = function(){
      return entries[entries.length-1];
    }

    self.firstEntry = function(){
      return entries[0];
    }

    self.forward = function(){
      if (pointer < entries.length-1)
        pointer = pointer + 1;
    }

    self.backward = function(){
      if (pointer > 0)
        pointer = pointer - 1;
    }

    self.isLast = function(){
      return (pointer == entries.length - 1);
    }

    self.isFirst = function(){
      return (pointer == 0);
    }
  }

  return {
    getInstance: function(){
      if (!instance)
        instance = new Record();
      return instance;
    }
  }

})(jQuery);
