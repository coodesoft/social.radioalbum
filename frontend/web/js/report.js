let callback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flag = data['flag'];

  switch (flag) {
    case Flags.getInstance().SAVE_SUCCESS:
      ModalBox.getInstance().show(Texts.getInstance().getT('success'), Texts.getInstance().getT('successReport'));
      break;
    case Flags.getInstance().SAVE_ERROR:
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'), Texts.getInstance().getT('errorReport'), '', 'danger');
      break;
    case Flags.getInstance().INVALID_ID:
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'), Texts.getInstance().getT('errorID')+response,  '', 'danger');
      break;
    default:

  }
}

let widget = function(){
  let formProcessor = FormProcessor.getInstance();
  formProcessor.setCallback(callback);
}

let register = Register.getInstance();
register.addRegister('report', widget, '#newReport');
