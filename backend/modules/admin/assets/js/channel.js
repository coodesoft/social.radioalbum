
let updateChannelCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  flag = data['flag'];
  let error = (flag == flags.UPDATE_ERROR) ? true : false;

  let alert = getAlertBox(response['text'], response['type']);
  $('#channelAdmin .messages').html(alert);

  let browser = Browser.getInstance();
  if (!error){
    setTimeout(function(){
      $('[data-context="nav-channels"]').click();
    },500);
  }
}

let readURL = function (input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#channelArt').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

let channelAdmin = function(){
  $(".input-art").change(function() {
    readURL(this);
  });

  let form = FormProcessor.getInstance();
  form.setCallback(updateChannelCallback);
}



let register = Register.getInstance();
register.addRegister('channel', channelAdmin, '#channelAdmin');
