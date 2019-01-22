

let userAdminCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  dataFlag = data['flag'];
  let error = (dataFlag == flags.SAVE_ERROR ||
               dataFlag == flags.ALREADY_EXIST ||
               dataFlag == flags.UPDATE_ERROR ||
               dataFlag == flags.DELETE_ERROR ||
               dataFlag == flags.LINK_ERROR) ? true : false;

  let alert = getAlertBox(response['text'], response['type']);
  $('#userAdmin .messages').html(alert);

  let browser = Browser.getInstance();


    if (!error){
      setTimeout(function(){
        if ($(browser.getContext().modal).length>0)
          $(browser.getContext().modal).empty();

        $('[data-context="admin-users"]').click();
      },500);
    } else
      setTimeout(function(){
        if ($(browser.getContext().modal).length>0)
          $(browser.getContext().modal).empty();
      }, 500);
}

let searchArtistCallback = function(data){
  $('.artist-search').html(data);
}

let configureEspDatePicker = function(){
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);
}

let _runLinkFunctions = function(){
  let form = FormProcessor.getInstance();

  $('#linkProfileForm').on('mouseenter', '#searchUserForm', function(){
    form.setCallback(searchArtistCallback);
  });

  $('#linkProfileForm').on('mouseenter', '#linkUserForm', function(){
    form.setCallback(userAdminCallback);
  });

  $('#userAdmin').off().on('click', 'input[type=radio]', function() {
    $('input[name="Link[model_id]"]').val($(this).val());
  });

  $('#inputArtistSearch').keypress(function (e) {
    if (e.which == 13 && $(this).val()!='') {
      $('#searchUserForm').submit();
    }
  });
}

let _runSearchUsersFunctions = function(){
  let status = Status.getInstance();
  let browser = Browser.getInstance();


  $('#userAdmin').on('click', '#showSearchBox', function(){
    browser.setExplorationTarget('.userAdminContent');
    if ($('#userSearchFormContainer').hasClass(status.HIDE))
      $('#userSearchFormContainer').removeClass(status.HIDE);
    else
      $('#userSearchFormContainer').addClass(status.HIDE);
  });

  $('#userAdmin').on('change', '#userSearchFormContainer input, #userSearchFormContainer select', function(){
    let action = $('#userSearchFormContainer>form').attr('action');
    let params = $('#userSearchFormContainer>form').serialize();
    url = action+"?"+params;
    $('#searchUsersLink').attr('href', url);
    $('#searchUsersLink')[0].click();
  });

  $('#usernameFilter').one('keyup', function (e) {
    let params = $('#userSearchFormContainer>form').serialize();
    if ((e.which == 13) || (e.which==8 && this.value=='')) {
      let action = $('#userSearchFormContainer>form').attr('action');
      url = action+"?"+params;
      $('#searchUsersLink').attr('href', url);
      $('#searchUsersLink')[0].click();
    } else if (this.value!=''){
      console.log(this.value);
      let action = $('#instantSearchUsersLink').attr('href');
      url = action+"?"+params;
      $('#searchUsersLink').attr('href', url);
      $('#searchUsersLink')[0].click();
    }
  });


  configureEspDatePicker();
  $('#lastAccessFilter').datepicker({
    dateFormat: "dd-mm-yy",
  });

}


let userAdmin = function(){
  let form = FormProcessor.getInstance();

  if ($('#userForm').length>0)
    form.setCallback(userAdminCallback);



  _runLinkFunctions();
  _runSearchUsersFunctions();


  $('#userForm').on('click', '#showPassword', function(){
    let target = $(this).attr('data-input');
    if ($(target).attr('type') == 'text')
      $(target).attr('type', 'password');
    else
     $(target).attr('type', 'text');
  });

}


let register = Register.getInstance();
register.addRegister('user', userAdmin, '#userAdmin');
