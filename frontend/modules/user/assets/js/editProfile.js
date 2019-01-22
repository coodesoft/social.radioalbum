
let editProfileCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flag = data['flag'];
  let dataFlag = Flags.getInstance();

  switch (flag) {
    case dataFlag.UPDATE_SUCCESS:
      ModalBox.getInstance().show(Texts.getInstance().getT('success'),Texts.getInstance().getT('editProfileSuccess'));
      $('[data-context="profile_area"]').click();
      console.log('asdasd');
      break;
    case dataFlag.UPDATE_ERROR:
      let errors = Texts.getInstance().getT('editProfileError') + " " + response;
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'), errors);
      break;
    case dataFlag.UPLOAD_ERROR:
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('uploadProfileImageError'));
      break;
  }
}

let widget = function(){
  let GENDER_CUSTOM = 3;

  $('#editProfile').off().on('change', '.gender-options', function(){
    let genderSelect = $(this).val();

    if (genderSelect == GENDER_CUSTOM){
        $('.gender-custom').attr('type', 'text');
    } else
      $('.gender-custom').attr('type', 'hidden');

  });

  $("#editprofileform-photo ").change(function() {
    preloadImage(this, '#profileImgPreview');
  });

  _formProcessor = FormProcessor.getInstance();
  _formProcessor.setCallback(editProfileCallback);

}


let register = Register.getInstance();
register.addRegister('editProfile', widget, '#editProfile');
