
let statusCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flag = data['flag'];

  if (flag == Flags.getInstance().SAVE_SUCCESS){
    let action = $('.report_'+response['id']+'_status .action-status');
    let div = action.find('div');
    div.empty();

    let i = document.createElement('i');
    i.setAttribute('class', 'fal ' + response['icon'] + " fa-2x clickeable");
    i.setAttribute('data-toggle', 'tooltip');
    i.setAttribute('data-placement', 'bottom');
    i.setAttribute('title', response['btnLabel']);
    div.html(i);

    let status = $('.report_'+response['id']+'_status .report-status');
    if (response['status']){
      status.removeClass('report-pending');
      status.addClass('report-processed');
    } else{
      status.removeClass('report-processed');
      status.addClass('report-pending');
    }
    status.text(response['statusLabel']);
  } else{
    let modal = ModalBox.getInstance();
    let texts = Texts.getInstance();
    modal.show(texts.getT('ops'), texts.getT('errorBrowPage'));
  }
}

let statusViewCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flag = data['flag'];

  if (flag == Flags.getInstance().SAVE_SUCCESS){
    let button = $('#changeReportStatus');
    button.text(response['btnLabel']);
    $('#statusLabel').html(response['statusLabel']);
  } else{
    let modal = ModalBox.getInstance();
    let texts = Texts.getInstance();
    modal.show(texts.getT('ops'), texts.getT('errorBrowPage'));
  }
}

let albumStatusCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flag = data['flag'];
  if (flag == Flags.getInstance().SAVE_SUCCESS){
      let button = $('#changeTargetStatus');
      button.text(response['btnLabel']);
      $('#targetStatus').html(response['statusLabel']);
    } else{
      let modal = ModalBox.getInstance();
      let texts = Texts.getInstance();
      modal.show(texts.getT('ops'), texts.getT('errorBrowPage'));
    }
}

let reportDeleteCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flag = data['flag'];

  let modal = ModalBox.getInstance();
  let texts = Texts.getInstance();

  switch (flag) {
    case Flags.getInstance().INVALID_ID:
      modal.show(texts.getT('ops'), texts.getT('idError'));
      break;
    case Flags.getInstance().DELETE_SUCCESS:
      let selector = '.report_'+response['id']+'_status';
      $(selector).remove();
      console.log(selector)
      modal.show(texts.getT('success'), texts.getT('removeOk'));
      break;
    case Flags.getInstance().DELETE_ERROR:
      modal.show(texts.getT('ops'), texts.getT('removeErr'));
      break;

    default:

  }
}



let report = function(){

  $('#reportsAdminPanel').off().on('click', '.action-status', function(){
    $(this).submit();
    FormProcessor.getInstance().setCallback(statusCallback);
  });

  $('#reportsAdminPanel').on('click', '.action-report .delete-report', function(){
    FormProcessor.getInstance().setCallback(reportDeleteCallback);
  });

  $('#reportView').off().on('click', '#changeReportStatus', function(){
    FormProcessor.getInstance().setCallback(statusViewCallback);
  })

  $('#reportView').on('click', '#changeTargetStatus', function(){
    FormProcessor.getInstance().setCallback(albumStatusCallback);
  });


}

let register = Register.getInstance();
register.addRegister('report-list', report, ['#reportsAdminPanel', '#reportView']);
