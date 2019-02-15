

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
}





let register = Register.getInstance();
register.addRegister('catalog', catalogAdmin, '#catalogAdmin');
