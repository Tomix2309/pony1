const login = (() => {
	'use strict';

	function emptyInput( inp ) {
		if (empty(inp.val())) {
			inp.focus();
			return false;
		}
	}

	function iniciarSesion() {
		const inps = ['nick', 'pass'];
		inps.map( inp => emptyInput($(`input[name="${inp}"]`)));
		// Por defecto
		$('#login_error').css('display', 'none');
   	$('#loading').show(300);
   	$('input[type="submit"]').addClass('disabled');
   	//
   	$('.btn-login').attr('value', 'Accediendo...').fadeIn(250);
   	$('#loading').fadeIn(250);
	
		const data = $('#loginForm').serialize();
		$.post(global_data.url + '/login-user.php', data, response => {
			console.log(response)
			switch (response.charAt(0)) {
				case '0':
					$('#login_error').css('display', 'block').html(response.substring(3));
			      $('input[type="submit"]').removeClass('disabled');
			      $('.btn-login').attr('value', 'Iniciar sesión');
				break;
				case '1':
					$('.btn-login').attr('value', response.substring(3));
		       	$('#loading').fadeOut(350);
					const redirect = global_data.url;
					location.href = redirect
				break;
			}
		})
		.fail(() => {
			$('#login_error').html('Error al intentar procesar lo solicitado').show();
	      $('#loading').hide(300);
		})
		.done(() => $('#loading').show(300))
	}

	return {
    	iniciarSesion: iniciarSesion,
  	};
})();