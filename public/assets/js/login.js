empty = n => {let e,r,t;const f=[undefined,null,!1,0,"","0"];for(r=0,t=f.length;r<t;r++)if(n===f[r])return!0;if("object"==typeof n){for(e in n)if(n.hasOwnProperty(e))return!1;return!0}return!1}

function obtenerParametroDeURL(nombreParametro) {
   var url = window.location.href;
   nombreParametro = nombreParametro.replace(/[\[\]]/g, "\\$&");
   var regex = new RegExp("[?&]" + nombreParametro + "(=([^&#]*)|&|#|$)"),
       resultados = regex.exec(url);
   if (!resultados) return null;
   if (!resultados[2]) return '';
   return resultados[2];
}

const login = (() => {
	'use strict';

	function wait(type, text) {
		if(type === 'start') {
			var opt = {
				effect : 'bounce',
				text : text,
				bg : "rgba(255,255,255,0.7)",
				color : "#000",
				waitTime : -1,
				textPos : 'vertical'
			}
		} else var opt = 'hide';
		$('#body').waitMe(opt);
	}

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
   	$('input[type="submit"]').addClass('disabled');
   	//
		wait('start', 'Redireccionando...');
	
		const data = $('#loginForm').serialize();
		$.post(global_data.url + '/login-user.php', data, response => {
			switch (response.charAt(0)) {
				case '0':
					$('#login_error').show().addClass('alert alert-danger position-absolute').html(response.substring(3));
			      $('input[type="submit"]').removeClass('disabled');
			      wait('end');
				break;
				case '1':
					wait('start', 'Redireccionando...');
					$('#login_error').remove();
					let redirectParam = obtenerParametroDeURL('redirect');
					if (redirectParam) {
               	location.href = decodeURIComponent(redirectParam);
	            } else {
						const redirect = global_data.url;
						location.href = redirect
					}
				break;
			}
		})
		.fail(() => {
			$('#login_error').html('Error al intentar procesar lo solicitado').show();
	      wait('end');
		})
		.done(() => $('#loading').show(300))
	}

	async function remind_resend(gew, type) {
		// Cerramos el modal para abrir otro
		const { value: email } = await Swal.fire({
  			title: (type==='password' ? 'Recuperar Contrase&ntilde;a' : 'Reenviar validaci&oacute;n'),
  			input: "email",
  			inputLabel: "Correo electrónico",
  			inputPlaceholder: "johndoe@example.com"
		})
		wait('start', 'Espere');
		if (email) {
			const page = (type === 'password') ? 'pass' : 'validation';
			const r_email = email;
			$.post(global_data.url + '/recover-'+page+'.php', {r_email}, receive => {
				wait('end');
				Swal.fire({
					icon: (receive.charAt(0) == '0' ? 'error' : 'success'),
					title: (receive.charAt(0) == '0' ? 'Opps!' : 'Hecho'),
					html: receive.substring(3)
				});
			})
		}
	}
	return {
    	iniciarSesion: iniciarSesion,
    	remind_resend: remind_resend
  	};
})();
// Las 2 formas de iniciar sesión
$(".btn.btn-login").on('click', () => login.iniciarSesion());
document.onkeydown = key => {
	if(key.code === 'NumpadEnter' || key.keyCode === 13 || key.code === 'Enter') login.iniciarSesion();
};