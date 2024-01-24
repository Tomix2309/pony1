const ruta = (type, ext) => {
	var direccion = (ext == 'php') ? global_data.url : global_data.img;
	var ira = (ext == 'php' ? '/files-' : 'images/files/') + type + (empty(ext) ? '' : `.${ext}`);
	return direccion + ira;
}
const Files = {
	carpeta: {
		crear: (act) => {
			if(!act) {
				$.get(ruta('crear-carpeta', 'php'), response => {
					mydialog.show();
					mydialog.title('Nueva Carpeta');
					mydialog.body(response);
					mydialog.buttons(true, true, 'Crear', 'Files.carpeta.crear(true)', true, false, true, 'Cancelar', 'close', true, true);
					mydialog.center();
				})
			} else {
				const datos = $('form[name=new-folder]').serialize();
				mydialog.procesando_inicio();
				$.post(ruta('new-folder', 'php'), datos, response => {
					const carName = $('input[name=car_name]');
					if(response.type === 0) {
						carName.focus();
						carName.parent().append('<small id="helper">'+response.msg+'</small>');
					} else if(response.type === 1) {
						$('#helper').remove();
						const { name, seo, img, enc } = response.data;
  						let clonar = $('.carpetas > .carpeta').first().clone();
					  	// Modificar los datos dentro del clon
					  	let folenc = enc ? 'encriptado' : 'carpeta';
					  	clonar.attr({href: ruta(`files/${folenc}/${seo}`)})
					  	clonar.find('.images').attr({ src: ruta(`carpeta-${img}`, 'png') });
						clonar.find('.carpeta-info > .d-block').text(name);
  						$('.carpetas').append(clonar);
					}
					carName.on('focus keyup', () => $('#helper').remove())
					mydialog.procesando_fin();
					mydialog.close();
				}, 'json')
			}
		},
		borrar: () => {},
		editar: () => {}
	},
	archivo: {
		opciones: (id, ver) => {
		    $('.item-options').each( (i, opt) => {
		    	if($(opt).data('id') == id) {
		    		$(opt).toggleClass('open closed');
		    	} else {
		    		$(opt).removeClass('open').addClass('closed');
		    	}
		   })
		},
		informacion: id => {
			$.getJSON(ruta('info', 'php'), { id }, response => {
				const {user, ext, format, name, weight, downloads, private, icon} = response;
				const img = ruta(`${icon}`, 'png')
				mydialog.show();
				mydialog.title('Información');
				mydialog.body(`<div class="p-2">
						<div  class="float-end" style="margin-top: 6px;margin-right:6px;"><img src="${img}"></div>
						<h3>${name}.${ext}</h3>
						<span class="d-block">Archivo: <strong>${private}</strong></span>
						<span class="d-block">Peso: <strong>${weight}</strong></span>
						<span class="d-block">Formato: <strong>${format}</strong></span>
						<span class="d-block">Veces descargado: <strong>${downloads}</strong></span>
					</div>`);
				mydialog.buttons(true, true, 'Cerrar', 'close', true, false, false);
				mydialog.center();
			})
		},
		mover: id => {
			const move = true;
			$.post(ruta('mover-archivo', 'php'), { id, move }, response => {
				let option = '';
				response.map( carpeta => option += `<option value="${carpeta.car_id}" data-seo="${carpeta.car_seo}">${carpeta.car_name}</option>`)
				mydialog.show();
				mydialog.title('Mover archivo');
				mydialog.body(`<h4>Seleccionar carpeta a mover archivo</h4>
					<select name="arc_folder" class="form-select" title="Seleccionar carpeta a mover">
						<option value="0">Carpeta raiz</option>
						${option}
					</select>
				`);
				mydialog.buttons(true, true, 'Mover ahora', 'Files.archivo.mover_ok('+id+')', true, false, true, 'Cancelar', 'close', true, true);
				mydialog.center();
			}, 'json')
		},
		mover_ok: id => {
			const arc_id = id;
			const selected = $('select[name=arc_folder]').find(':selected');
			const arc_folder = parseInt($('select[name=arc_folder]').val());
			const arc_name = selected.text();
			const arc_seo = selected.data('seo');
			$.post(ruta('mover-seleccion', 'php'), { arc_id, arc_folder }, response => {
				let status = (response.charAt(0) === '0');
				mydialog.alert((status ? 'Error' : 'Bien'), response.substring(3), false);
				if(!status) {
					let addFolder = `<a href="${global_data.url}/files/carpeta/${arc_seo}" class="fw-bold text-primary" rel="internal">${arc_name}</a>`;
					let h4mas = $('#archivo-' + arc_id + ' h4').text();
					let arc_code = $('#arc_code').text();
					$('#archivo-' + arc_id + ' h4').html('').html(`${addFolder}\\${h4mas}`);
					// Aumentar el contador
					const etiq = $('#carpeta-' + arc_folder + ' .carpeta-info > small');
					let contar = parseInt(etiq.text())
					contar++;
					etiq.html(contar + ' Archivo' + (contar > 1 ? 's' : ''));
				}
			})
		},
		editar: id => {},
		eliminar: id => {},
		favorito: arc_id => {
			$.post(ruta('favorito', 'php'), { arc_id }, response => {
				let status = parseInt(response.charAt(0))
				mydialog.alert((status ? 'Bien':'Error'), response.substring(3), false)
				if(status) $('#btnfavorito').html('Guardado en favoritos');
			})
		}
	}
}
$(document).ready(() => {
	if ($('#file_newcom').length && !$('.wysibb-texarea').length) {
	   $('#file_newcom').removeAttr('onblur onfocus class style title').css('height', '80').html('').wysibb({
	      	buttons: "smilebox,|,bold,italic,underline,|,img,link"
	   	});
	}
})