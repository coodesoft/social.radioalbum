var ModalBox = (function(){

  function ModalBox(){

    let contModal = '';

    this.show = function(tit, msg, pie = "", type="success"){
      let modalHTML = '<div class="modal fade in ra-mdl-'+type+'" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalBox1Label" style="display: block;">'+
        '<div class="modal-dialog" role="document">' +
        '  <div class="modal-content">'+
            '<div class="modal-header">' +
              '<button type="button" class="close ra-close-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<div class="modal-head-title">' +
                '<div class="logo-modal"></div>' +
                '<h4 class="modal-title" id="myModalLabel">'+tit+'</h4>'+
              '</div>'+
            '</div>'+
            '<div class="modal-body">'+msg+'</div>'+
            '<div class="modal-footer">'+pie+'</div>'+
        '</div></div></div>';

        $(contModal).html(modalHTML);
    }

    this.setContModal = function(c){
      contModal = c;
    }

    this.clean = function(){
      $(contModal).empty();
    }

    this.createContainer = function(cId){
      $lastDiv = $('body').children('div').filter(':last');
      if ($('#'+cId).length == 0)
      $lastDiv.after('<div id="'+cId+'"></div>');
      contModal = '#'+cId;
    }
  }
  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new ModalBox();
      return instance;
    }
  }
})();
