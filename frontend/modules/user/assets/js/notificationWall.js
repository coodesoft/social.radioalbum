


let widget = function(){

  $('#notificationWall').off().on('click', 'a[data-action="notification.mark-as-read"]', function(e){
    e.preventDefault(); e.stopPropagation();
    let requester = Requester.getInstance();

    let link = this;

    let done = function(data, textStatus, jqXHR){
      if (data['response']){
        $(link).addClass('hidden');
        $(link).siblings().removeClass('hidden');
        $(link).closest('li').removeClass('unreaded').addClass('readed');
      } else
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
    };

    let error = function(data, textStatus, jqXHR){
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
    };

    requester.requestJson($(link).attr('href'), done, error);
  });

  $('#notificationWall').on('click', 'a[data-action="notification.mark-as-unread"]', function(e){
    e.preventDefault(); e.stopPropagation();
    let requester = Requester.getInstance();

    let link = this;

    let done = function(data, textStatus, jqXHR){
      if (data['response']){
        $(link).addClass('hidden');
        $(link).siblings().removeClass('hidden');
        $(link).closest('li').removeClass('readed').addClass('unreaded');

      } else
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
    };

    let error = function(data, textStatus, jqXHR){
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
    };

    requester.requestJson($(link).attr('href'), done, error);
  });

}

let register = Register.getInstance();
register.addRegister('notificationWall', widget, '#notificationWall');
