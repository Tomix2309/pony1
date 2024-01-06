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
			let type = parseInt(response.charAt(0));
			let text = response.substring(3);
			if(type === 0) {
				$('#login_error').css('display', 'block').html(text);
	         $('input[type="submit"]').removeClass('disabled');
	         $('.btn-login').attr('value', 'Iniciar sesión');
			} else if(type === 1) {
	         if (text == 'Home') location.href = '/';
	         else if (text == 'Cuenta') location.href = '/cuenta/';
	         else location.reload();
	         $('#loading').fadeOut(350);
			}
		})
		.fail(() => {
			$('#login_error').html('Error al intentar procesar lo solicitado').show();
	      $('#loading').hide(300);
		})
		.complete(() =>  $('#loading').show(300))
	}

	return {
    	iniciarSesion: iniciarSesion,
  	};
})();