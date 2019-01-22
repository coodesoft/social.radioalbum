let flags = Flags.getInstance();

let success = function(data, textStatus){
  let status = Status.getInstance();
  $('.init-analisis').removeClass('disabled');
  if (flags.SUCCESS == textStatus){
    $('#analisisLoader img').addClass(status.HIDE);
    $('#analisisResult .results').html(data);
    $('#analisisResult .results').trigger(status.LOADED);
  }
}

let error = function(data, textStatus){
  $('.init-analisis').removeClass('disabled');
  let modal = ModalBox.getInstance();
  let texts = Texts.getInstance();
  modal.show(textStatus,texts.getT('errorBrowPage'));
}

let catalogAdmin = function(){
  let requester = Requester.getInstance();
  let status = Status.getInstance();
  $('#analisisLoader img').addClass(status.HIDE);
  $('#migrationArea').off().on('click', '.init-analisis', function(e){
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('disabled');
    $('#analisisResult .results').empty();
    $('#analisisLoader img').removeClass(status.HIDE);
    requester.request(this.href, success, error);
  });

}


let register = Register.getInstance();
register.addRegister('catalog', catalogAdmin, '#migrationArea');
