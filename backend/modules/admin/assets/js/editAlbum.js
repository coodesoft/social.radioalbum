
let editAlbumCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  let error = (data['flag'] == flags.SAVE_ERROR) ? true : false;
  let browser = Browser.getInstance();
  let alert = getAlertBox(response['text'], response['type']);


  browser.reNav();
  setTimeout(function(){
    $('#albumAdminEdit .messages').html(alert);
    setTimeout(function(){
        $('#albumAdminEdit .messages').empty();
      }, 1000);

  }, 500)


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
