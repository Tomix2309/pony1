const agregar = (() => {
	'use strict';

	const mensaje = (type, message = '') => {
   	if(typeof type == 'boolean') {
   		$('.errormsg').removeClass('text-danger').html('').hide();
   	} else if(typeof type == 'object') {
   		type.parent().find('span.errormsg').addClass('text-danger').html(message).show()
   		type.focus();
   	}
	}

	const contarMayus = campo => {
		var len = campo.val().length,
		 strip = campo.val().replace(/([A-Z])+/g, '').length, 
		 strip2 = campo.val().replace(/([a-zA-Z])+/g, '').length, 
		 percent = (len  - strip) / (len - strip2) * 100;
		return percent;
	}
	
	const titulo = () => {
		const campo = $('input[name=f_title]');
		let contenido = campo.val();
		campo.on('keyup', () => {
			mensaje(false);
			if(campo.val().length >= 5 && agregar.contarMayus(campo) > 70) {
				mensaje(campo, 'El t&iacute;tulo no debe estar en may&uacute;sculas')
			}
		})
	}

	const descripcion = () => {
		const max = 250;
		const campo = $('textarea[name=f_description]');
		let contenido = campo.val();
		campo.on('keyup', () => {
			if(campo.val().length > max) {
				// Recortamos el texto
				campo.html(contenido.substr(0, max));
				agregar.mensaje(campo, `La descripción no puede exceder los ${max} carácteres.`);
			} else {
				agregar.mensaje(false);
			}
		});
	}

	// Retornar la función mensaje para que esté disponible fuera de la función de expresión
   return {
   	contarMayus,
   	titulo,
      mensaje,
      descripcion
   };
})();

$(document).ready(() => {

	agregar.titulo();
	agregar.descripcion();

})