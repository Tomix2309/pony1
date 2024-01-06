function desvincular(name) {
	$.post(global_data.url + '/cuenta-desvincular.php', { name }, response => {
		if(response) location.reload();
	})
}
function input_fake(name) {
	$('.input-hide-' + name).hide();
	$('.input-hidden-' + name).show().focus();
}
/** Desactivar cuenta **/
function desactivate(des) {
		if(des == 0) {
			mydialog.show();
			mydialog.title('Desactivar Cuenta');
			mydialog.body(`<strong>&#191;Seguro que quiere desativar su cuenta?</strong><br>
			<span>Si desactiva su cuenta, todo el contenido relacionado a usted dejar&aacute; de ser visible durante un tiempo.</span><br>
			<span>Pasado ese tiempo, la administraci&oacute;n borrar&aacute; todo su contenido y no podr&aacute; recuperarlo.</span><br>`);
			mydialog.buttons(true, true, 'Desactivar cuenta ahora!', 'desactivate(1)', true, false, true, 'No', 'close', true, true);
			mydialog.center();
		} else {
			var pass = $('#passi');
	      $('#loading').fadeIn(250); 
			$.post(global_data.url + '/cuenta.php?action=desactivate', 'validar=ajaxcontinue', function(a){
			   mydialog.alert((a.charAt(0) == '0' ? 'Opps!' : 'Hecho'), (a.charAt(0) == '0' ? 'No se pudo desactivar' : 'Cuenta desactivada'), true);
			   mydialog.center();
	         $('#loading').fadeOut(250); 
			});
	   }
}

const cuenta = {
	alerta: (alerta) => {
		$("#alerta_guarda").show().html(alerta)
		window.scrollTo(0, 0)
		// Despues de 5s quitamos el alerta
		setTimeout(() => $("#alerta_guarda").hide().html(''), 5000)
	},
	chgpais: () => {
		// Campo pais
		const pais_code = $("select[name=pais]").val();
		const estado = $("select[name=estado]");
		if(empty(pais_code)) estado.addClass('disabled').attr('disabled', 'disabled').val('');
		else {
			//Obtengo las estados
			$(estado).html('');
         $('#loading').fadeIn(250); 
         $.get(global_data.url + '/registro-geo.php', { pais_code }, h => {
         	if(h.charAt(0) === '1') estado.append(h.substring(3)).removeAttr('disabled').val('').focus();
         	$('#loading').fadeOut(250); 
         })
      }
	},
	guardar_datos: () => {
		$('#loading').slideDown(250);
		$.post(global_data.url + '/cuenta-guardar.php', $("form[name=editarcuenta]").serialize(), response => {
			cuenta.alerta(response.error)
		}, 'json');
	}
}

/*
<input type="file" class="custom-file-input browse" name="desktop" onchange="$(this).next().after().text($(this).val().split('/\/\').slice(-1)[0].replace('C:\/fakepath\',''))" id="file-avatar">
*/
/* COMPLEMENTO AGREGADO PARA HACER MEJOR EL INPUT FILE */

function cambiarnombre() {
	$('.inputfile').on('change', function(e) {
	   var fileName = '';
	   if (e.target.value) fileName = e.target.value.split('\\').pop();
	   if (fileName) {
	      $('.custom-file-label').html(fileName);
	   } else $('.custom-file-label').html('');
	});
}
const avatar = {
	uid: false,
	key: false,
   ext: false,
	informacion: '',
	url: '',
	current: false,
	success: false,
	total: 2,
	imgCrop: '',
	accion:  {
		avamodal: function(user, paso) {
			if(paso == 0) {
				$.post(global_data.url + '/upload-cambiar.php', { user }, response => {
					mydialog.show(true);
					mydialog.title('Cambiar avatar');
					mydialog.body('<div class="avatares">'+response+'</div>');
		      	mydialog.buttons(true, true, 'Aceptar cambio', 'avatar.accion.avamodal('+user+', 1)', true, false);
				})
			} else {
				mydialog.show(true);
				mydialog.title('Éxito');
				mydialog.body('Se ha cambiado correctamente!');
		      mydialog.buttons(true, true, 'Cerrar', 'close', true, false);
		      mydialog.center();
				var img_url = global_data.url + '/files/avatar/' + usuario + '.webp?' + getRandom();
				$('#cambiar-foto').attr({'src': img_url}).fadeIn();
			}
		},
		cambiar: user => {
			$.post(global_data.url + '/upload-cambiar.php', { user }, response => {
				$('.horizontal, #cambiar').hide();
				$('.avatares').html(response).show();
				$('#ccambiar').show()
			});
		},
		seleccionar: (usuario, id) => {
			$.post(global_data.url + '/upload-subir.php', { usuario, id }, link => {
				$('.avatar-big, .avatar-head').attr('src', link);
			});
		},
		tipo: seleccion => {
			$('.grid-avatares').hide();
			var html = '';
			if(seleccion == 'pc') {
				html += `<div id="avatar-local">
					<p>Subir una imagen de perfil desde tu PC.</p>
					<div class="custom-file custom-renove">
						<input type="file" class="custom-file-input browse" name="desktop" onchange="$(this).next().after().text($(this).val().split('/\/\').slice(-1)[0].replace('C:\/fakepath\',''))" id="file-avatar">
						<label class="custom-file-label" for="file-avatar" data-browse="Elegir">Seleccionar archivo</label>
					</div>
					<button type="button" onclick="avatar.subir('desktop')" class="avatar-next local btn btn-success mt-3">Subir</button>
					<button onclick="avatar.accion.volver();" class="btn btn-success mt-3">Volver</button>
				</div>`;
			} else {
				html += `<div class="form-group">
					<p>Subir una imagen de perfil desde URL.</p>
					<input type="text" class="form-input" placeholder="Link de tu avatar" name="url" id="url-avatar" size="45"/>
					<button type="button" onclick="avatar.subir('url');" class="avatar-next button button-success mt-3 url">Subir</button>
					<button onclick="avatar.accion.volver();" class="btn btn-success mt-3">Volver</button>
				</div>`;
			}
			$('#type-selection').html(html);
		},
		volver: () => {
			$('.grid-avatares').show();
			$('#type-selection').html('');
		}
	},
	fetching: async (url, data) => {
		const uploader = await fetch(global_data.url + '/upload-' + url + '.php', {
			method: 'POST',
			body: data
		})
		const response = await uploader.json();
		return response;
	},
	subir: async (type = 'desktop') => {
		$(".avatar-loading").show();
		const myInput = $(`input[name=${type}]`)
		const datoUrl = new FormData();
		datoUrl.append('url', (type === 'url') ? myInput.val() : myInput[0].files[0]);
		const response = await avatar.fetching('avatar', datoUrl)
		cambiarnombre()
		if(!empty(response)) avatar.subiendo(response);
	},
	subiendo: response => {
		if (response.error == 'success') avatar.success = true;
		else if (response.msg) {
         avatar.key = response.key;
         avatar.ext = response.ext;
         avatar.cortar(response.msg);
		} else cuenta.alerta(response.error, 0);
		$(".avatar-loading").hide();
	},
	cortar: img => {
		newImageUpload = img + '?' + Math.random();
		mydialog.show(true);
		mydialog.title("Cortar avatar");
		mydialog.body('<img class="avatar-cortar" src="'+newImageUpload+'">');
		mydialog.buttons(true, true, 'Cortar', `avatar.guardar()`, true, true, true, 'Cancelar', 'close', true, false);
		mydialog.center();
		avatar.imgCrop = $('.avatar-cortar');
		$("#avatar-img, .avatar-head").on('load', () => {
         var croppr = new Croppr('.avatar-cortar', {
         	// Mantemos el tamanio cuadrado 1:1
            aspectRatio: 1,
			   // Empieza con el tamaño 160px x 160px
            startSize: [160, 160, 'px'],
			   // Minimo de 160px x 160px
            minSize: [160, 160, 'px'],
    			// Enviamos las coordenadas para cortar la imagen
    			// Tiene la funcion onCropEnd ya que es como va a quedar
            onCropEnd: data => avatar.informacion = data,
            onCropMove: avatar.vistaPrevia
         });
      }).attr("src", newImageUpload);
	},
	vistaPrevia: function (coords) {
		avatar.coords = coords
		let rx = 160 / coords.width;
		let ry = 160 / coords.height;
		$('#avatar-img').css({
			width: Math.round(rx * avatar.imgCrop[0].width) + 'px',
			height: Math.round(ry * avatar.imgCrop[0].height) + 'px',
			marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			marginTop: '-' + Math.round(ry * coords.y) + 'px'
		});
	},
	guardar: async () => {
		if (empty(avatar.informacion)) cuenta.alerta('Debes seleccionar una parte de la foto', 0);
		else {
			const allcoord = {
				key: avatar.key,
				ext: avatar.ext,
				x: avatar.informacion.x,
				y: avatar.informacion.y,
				w: avatar.informacion.width,
				h: avatar.informacion.height
			};
			const coordenadas = new FormData();
			for (const prop in allcoord) coordenadas.append(prop, allcoord[prop]);
			const resultado = await avatar.fetching('crop', coordenadas)
			if(resultado.error === "success") {
				mydialog.body("Tu avatar se ha creado correctamente...");
			   mydialog.buttons(true, true, 'Aceptar', 'close', true, true, false);
			   avatar.recargar();
			}
		}
	},
	recargar: () => $("#avatar-img, .avatar-head").addClass('img-fit-contain').attr({
		src: avatar.current + '?t=' + Math.round(Math.random()),
		style: ''
	}),
}