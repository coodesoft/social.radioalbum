
let artistAdminCallback = function(data){
  data = JSON.parse(data);
  let alert;
  let response = data['response'];
  let flags = Flags.getInstance();
  flag = data['flag'];
  if ( flag == flags.UPDATE_SUCCESS ){
      console.log(data);
    $('a[data-context="admin-artists"]').click();
  }else{
      alert = getAlertBox(response['text'], response['type']);
      $('#artistAdmin .messages').html(alert);
  }
}

let readURL = function (input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#artistArt').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

let artistAdmin = function(){
  $(".input-art").change(function() {
    readURL(this);
  });

  let form = FormProcessor.getInstance();
  form.setCallback(artistAdminCallback);

	$('#artistAdmin').off().on('click', 'a[data-action="delete-artist"]', function(e){
		e.preventDefault();
		e.stopPropagation();

		let title = $(this).attr('data-title');
		let msg = 'Estas por eliminar el Artista: '+title+'. Los discos de este artista quedarán huérfanos. Su eliminación debe ser manual. Esta acción no puede deshacerse. ¿Deseas continuar?';
		let proceed = confirm(msg);
		if (proceed){

			let success = function(data, textStatus){
				data =  JSON.parse(data);

				if (data['flag'] == flags.DELETE_SUCCESS){
					let browser = Browser.getInstance();
					browser.reNav();
				} else {
					let alert = getAlertBox(data['text'], data['type']);
			    $('#artistAdmin .messages').html(alert);
			    setTimeout(function(){
			        $('#artistAdmin .messages').empty();
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
register.addRegister('artistAdmin', artistAdmin, '#artistAdmin');
