
let channelAdminCallback = function(data){
  data = JSON.parse(data);
  let alert;
  let response = data['response'];
  let flags = Flags.getInstance();
  flag = data['flag'];

  if ( (flag == flags.SAVE_SUCCESS) || (flag == flags.UPDATE_SUCCESS) )
    $('[data-context="admin-channels"]').click();
  else{
      alert = getAlertBox(response['text'], response['type']);
      $('#channelAdmin .messages').html(alert);
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
  form.setCallback(channelAdminCallback);

	$('#channelAdmin').off().on('click', 'a[data-action="delete-channel"]', function(e){
		e.preventDefault();
		e.stopPropagation();

		let title = $(this).attr('data-title');
		let msg = 'Estas por eliminar un Canal: '+title+'. Esta acción no puede deshacerse. ¿Deseas continuar?';
		let proceed = confirm(msg);
		if (proceed){

			let success = function(data, textStatus){
				data =  JSON.parse(data);

				if (data['flag'] == flags.DELETE_SUCCESS){
					let browser = Browser.getInstance();
					browser.reNav();
				} else {
					let alert = getAlertBox(data['text'], data['type']);
			    $('#userAdmin .messages').html(alert);
			    setTimeout(function(){
			        $('#userAdmin .messages').empty();
		      }, 1000);
				}

			}

			let error = function(data, textStatus){
				alert('Se produjo un error de red: '+data);
			}
			requester.request(this.href, success, error);

		}
	});

}



let register = Register.getInstance();
register.addRegister('channelAdmin', channelAdmin, '#channelAdmin');
