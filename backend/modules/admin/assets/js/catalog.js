

let catalogAdmin = function(){
	var requester = Requester.getInstance();
	var flags = Flags.getInstance();

	$('#catalogAdmin').off().on('click', 'a[data-action="enable-album"]', function(e){
		e.preventDefault();
		e.stopPropagation();

		let self = this;

		let success = function(data, textStatus){
			data =  JSON.parse(data);
			if (data['flag'] == flags.SAVE_SUCCESS){
				let element  = '<span class="fa-layers fa-fw">';
					element += '<i class="fal fa-circle" data-fa-transform="grow-15"></i>';
					element += '<i class="far fa-eye-slash" data-fa-transform="shrink-3"></i>';
					element += '</span>';
					$(self).html(element);
					$(self).attr('data-action', 'disable-album');
					self.href = data['response'];

			} else{
				alert('Se produjo el siguiente error: '+data['response']);
			}
		}

		let error = function(data, textStatus){
			alert('Se produjo un error de red: '+data);
		}

		requester.request(this.href, success, error);
	});

	$('#catalogAdmin').on('click', 'a[data-action="disable-album"]', function(e){
		e.preventDefault();
		e.stopPropagation();

		let self = this;

		let success = function(data, textStatus){
			data =  JSON.parse(data);
			if (data['flag'] == flags.SAVE_SUCCESS){
				let element  = '<span class="fa-layers fa-fw">';
					element += '<i class="fal fa-circle" data-fa-transform="grow-15"></i>';
					element += '<i class="far fa-eye" data-fa-transform="shrink-3"></i>';
					element += '</span>';
					$(self).html(element);
					$(self).attr('data-action', 'enable-album');
					self.href = data['response'];
			} else{
				alert('Se produjo el siguiente error: '+data['response']);
			}
		}

		let error = function(data, textStatus){
			alert('Se produjo un error de red: '+data);
		}

		requester.request(this.href, success, error);
	});

	$('#catalogAdmin').on('click', 'a[data-action="delete-album"]', function(e){
		e.preventDefault();
		e.stopPropagation();

		let title = $(this).attr('data-title');
		let msg = 'Estas por eliminar un Álbum: '+title+'. Las canciones de este álbum que se encuentren en Colecciones de usuarios serán borradas. Esta acción no puede deshacerse. ¿Deseas continuar?';
		let proceed = confirm(msg);
		if (proceed){

			let success = function(data, textStatus){
				data =  JSON.parse(data);

				if (data['flag'] == flags.DELETE_SUCCESS){
					let browser = Browser.getInstance();
					browser.reNav();
				} else {
					let alert = getAlertBox(response['text'], response['type']);
			    $('#userAdmin .messages').html(alert);
			    setTimeout(function(){
			        $('#albumAdminEdit .messages').empty();
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
register.addRegister('catalog', catalogAdmin, '#catalogAdmin');
