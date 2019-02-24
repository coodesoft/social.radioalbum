
let editAlbumCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  flag = data['flag'];
  let error = (flag == flags.SAVE_ERROR) ? true : false;

  let alert = getAlertBox(response['text'], response['type']);
  $('#albumAdminEdit .messages').html(alert);
    setTimeout(function(){
      $('#albumAdminEdit .messages').empty();
    }, 1000)

}

let albumAdmin = function(){

  $(".input-art").change(function() {
    preloadImage(this, '#albumArt');
  });

  let form = FormProcessor.getInstance();
  form.setCallback(editAlbumCallback);

}



let register = Register.getInstance();
register.addRegister('albumEdit', albumAdmin, '#albumAdminEdit');
