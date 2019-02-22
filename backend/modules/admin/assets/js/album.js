
let uploadAlbumCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  flag = data['flag'];
  let error = (flag == flags.SAVE_ERROR) ? true : false;

  let alert = getAlertBox(response['text'], response['type']);
  $('#albumAdmin .messages').html(alert);

  let browser = Browser.getInstance();
  if (!error){
    setTimeout(function(){
      console.log(error);
      $('[data-context="migrate_multimedia"]').click();
    },500);
  } else{
    setTimeout(function(){
      $('#albumAdmin .messages').empty();
    }, 1000)
  }
}

let albumAdmin = function(){
  $(".input-art").change(function() {
    preloadImage(this, '#albumArt');
  });

  let form = FormProcessor.getInstance();
  form.setCallback(uploadAlbumCallback);


  $('#albumAdmin').off().on('click', '#chooseArtist', function(){
    if ($(this).is(':checked')){
      $('#uploadalbumform-storedartist').removeAttr('disabled');
      $('#uploadalbumform-artist').attr('disabled', true);
    } else{
      $('#uploadalbumform-storedartist').attr('disabled', true);
      $('#uploadalbumform-artist').removeAttr('disabled');
    }

  });

}



let register = Register.getInstance();
register.addRegister('album', albumAdmin, '#albumAdmin');
