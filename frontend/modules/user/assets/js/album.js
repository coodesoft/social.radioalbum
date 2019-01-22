
let uploadAlbumCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  flag = data['flag'];
  let error = (flag == flags.UPLOAD_ERROR) ? true : false;

  let alert = getAlertBox(response['text'], response['type']);
  $('#albumAdmin .messages').html(alert);

  let browser = Browser.getInstance();
  if (!error){
    setTimeout(function(){
      $('[data-context="nav-albums"]').click();
    },500);
  }
}

let albumAdmin = function(){
  $(".input-art").change(function() {
    preloadImage(this, '#albumArt');
  });

  let form = FormProcessor.getInstance();
  form.setCallback(uploadAlbumCallback);
}



let register = Register.getInstance();
register.addRegister('album', albumAdmin, '#albumAdmin');
