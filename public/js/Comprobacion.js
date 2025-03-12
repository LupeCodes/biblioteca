window.addEventListener('load', function(){
	email.addEventListener('change', function(){
		fetch("/User/checkemail/"+this.value, {
			"method":"GET"
		})
		.then(function(respuesta){
			return respuesta.json();
		})
		.then(function(json){
			if(json.status == 'OK')
				comprobacion.innerHTML =
					json.data.found ? 'Este email ya está registrado': '';
			else
				comprobacion.innerHTML = 'No se pudo comprobar.';		
		});
	});
});