const fotos = (() => {

	/*function countUpperCase(string) {
		var len = string.length, strip = string.replace(/([A-Z])+/g, '').length, strip2 = string.replace(/([a-zA-Z])+/g, '').length, percent = (len  - strip) / (len - strip2) * 100;
		return percent;
	}*/
	function countUpperCase(string) {
   	const totalCharacters = string.length;
   	const uppercaseCharacters = (string.match(/[A-Z]/g) || []).length;
   	const percentageUppercase = (uppercaseCharacters / totalCharacters) * 100 || 0;
   	return percentageUppercase > 70;
	}

	function ControlLargo(obj) {
		const value = $(obj).val();
	   value = value.substr(0, 1500);
	   fotos.mostrarError(obj, 'La descripci&oacute;n no debe exeder los 500 caracteres.', (value.length > 1500));
	}

	/**
	 * Muestra u oculta un mensaje de error en un elemento específico.
	 * @param {object} element - Elemento jQuery al que se aplicará el mensaje de error.
	 * @param {string} message - Mensaje de error que se mostrará u ocultará.
	 * @param {boolean} shouldHide - Indica si se debe ocultar (true) o mostrar (false) el mensaje de error.
	*/
	function mostrarError(element, message, shouldHide = false) {
		if (!(element instanceof jQuery)) {
		   console.info('El primer parámetro debe ser un objeto jQuery válido.');
		   return;
		}
		if (typeof shouldHide !== 'boolean') {
		   console.error('El tercer parámetro debe ser un valor booleano.');
		   return;
		}
		const functionClass = shouldHide ? 'addClass' : 'removeClass';
		const html = shouldHide ? message : '';
		const showHide = shouldHide ? 'show' : 'hide';
		console.log(functionClass, html)
		element.parent('li')[functionClass]('error').children('span.errormsg').html(html)[showHide]();
		//if (shouldHide) window.scrollTo(element.parent('li'), 500);
	}

	return {
		countUpperCase,
		ControlLargo,
		mostrarError
	}

})();
// Esto es solamente para comprobar!
$(document).ready(() => {
	// QUITAR LOS ERRORES
	$('.required').on('keyup change', function() {
		//if ($.trim($(this).val())) fotos.mostrarError($(this), '', true);
	});
	// CHECAR EL TITULO
	$('input[name=f_title]').on('keyup', function() {
		let count = fotos.countUpperCase($(this).val());
		let act = ($(this).val().length >= 5 && count) 
		let message = ($(this).val().length <= 5) ? 'El titulo debe tener más de 5 caracteres' : (count ? 'El t&iacute;tulo no debe estar en may&uacute;sculas' : '');
		fotos.mostrarError($(this), message, act);
	});
});