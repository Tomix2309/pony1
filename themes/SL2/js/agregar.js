function print_editor() {
   //Editor de posts
   if ($('#markItUp').length && !$('.wysibb-texarea').length || $('#wysibb').length && !$('.wysibb-texarea').length) {
      $('#markItUp, #wysibb').removeAttr('onblur onfocus class style').css('height', '400').addClass('required').wysibb();
      $('#moreemofn, #emoticons').remove();
   }
}	


function countUpperCase(string) {
	var len = string.length, strip = string.replace(/([A-Z])+/g, '').length, strip2 = string.replace(/([a-zA-Z])+/g, '').length, percent = (len  - strip) / (len - strip2) * 100;
	return percent;
}
//
function showError(obj, str) {
	if (obj.tagName.toLowerCase() == 'textarea') {
		obj = $(obj).parent().parent();
	}
	$(obj).parent('div').children('span.errormsg').addClass('text-danger').html(str).show(); // TODO QUE ONDA
	ScrollToMin($(obj).parent('div'), 500);
}
//
function hideError(obj) {
	if (obj.tagName.toLowerCase() == 'textarea') {
		obj = $(obj).parent().parent();
	}
	$(obj).parent('div').children('span.errormsg').removeClass('text-danger').html('').hide();
}
//
$(window).on("load", function() {
	$('#borrador-save').on('click', function(e) {
		var params = '&titulo=' + encodeURIComponent($('input[name="titulo"]').val());
		params += '&imagen=' + encodeURIComponent($('input[name="imagen"]').val());
		params += '&cuerpo=' + encodeURIComponent($('textarea[name="cuerpo"]').bbcode());
		params += '&tags=' + encodeURIComponent($('input[name="tags"]').val());
		params += '&categoria=' + encodeURIComponent($('select[name="categoria"]').val());
		params += $('input[name="privado"]').is(':checked') ? '&privado=1' : '';
		params += $('input[name="sin_comentarios"]').is(':checked') ? '&sin_comentarios=1' : '';
		params += $('input[name="visitantes"]').is(':checked') ? '&visitantes=1' : '';
		params += $('input[name="smileys"]').is(':checked') ? '&smileys=1' : '';
		params += $('input[name="patrocinado"]').is(':checked') ? '&patrocinado=1' : '';
		params += $('input[name="sticky"]').is(':checked') ? '&sticky=1' : '';
		$('div#borrador-guardado').html('Guardando...');
		borrador_setTimeout = setTimeout('borrador_save_enabled()', 60000);
		borrador_save_disabled();

		//Actualizo el borrador id
		if(!empty($('input[name="borrador_id"]').val())){
			$.ajax({
				type: 'POST',
				url: global_data.url + '/borradores-guardar.php',
				data: params + '&borrador_id=' + encodeURIComponent($('input[name="borrador_id"]').val()),
				success: function(h){
					switch(h.charAt(0)){
						case '0': //Error
							clearTimeout(borrador_setTimeout);
							borrador_setTimeout = setTimeout('borrador_save_enabled()', 5000);
							borrador_ult_guardado = h.substring(3);
							$('div#borrador-guardado').html(borrador_ult_guardado);
						break;
						case '1': //Guardado
							var currentTime = new Date();
							borrador_ult_guardado = 'Guardado a las ' + currentTime.getHours() + ':' + currentTime.getMinutes() + ':' + currentTime.getSeconds() + ' hs.';
							$('div#borrador-guardado').html(borrador_ult_guardado);
						break;
					}
				},
				error: function(){
					mydialog.error_500('save_borrador()');
				}
			});
		}else{
			$.ajax({
				type: 'POST',
				url: global_data.url + '/borradores-agregar.php',
				data: params,
				success: function(h){
					switch(h.charAt(0)){
						case '0': //Error
							clearTimeout(borrador_setTimeout);
							borrador_setTimeout = setTimeout('borrador_save_enabled()', 5000);
							borrador_ult_guardado = h.substring(3);
							$('div#borrador-guardado').html(borrador_ult_guardado);
						break;
						case '1': //Creado
							$('input[name="borrador_id"]').val(h.substring(3));
							var currentTime = new Date();
							borrador_ult_guardado = 'Guardado a las ' + currentTime.getHours() + ':' + currentTime.getMinutes() + ':' + currentTime.getSeconds() + ' hs.';
							$('div#borrador-guardado').html(borrador_ult_guardado);
						break;
					}
				},
				error: function(){
					mydialog.error_500('save_borrador()');
				}
			});
		}
	});
});



var borrador_setTimeout;
var borrador_ult_guardado = '';
var borrador_is_enabled = true;

function borrador_save_enabled(){
	if($('input#borrador-save'))
		$('input#borrador-save').removeClass('disabled').removeAttr('disabled');
	borrador_is_enabled = true;
}
function borrador_save_disabled(){
	if($('input#borrador-save'))
		$('input#borrador-save').addClass('disabled').attr('disabled', 'disabled');
	borrador_is_enabled = false;
}
//
var confirm = true;
window.onbeforeunload = confirmleave;
function confirmleave() {
	if (confirm && ($('input[name=titulo]').val() || $('textarea[name=cuerpo]').bbcode())) return "Este post no fue publicado y se perdera.";
}
//
var tags = false;
$(document).ready(function(){
	// QUITAR LOS ERRORES
	$('.required').on('keyup change',function(){
		if ($.trim($(this).val())) hideError(this);
	});
	// CHECAR EL TITULO
	$('input[name=titulo]').on('keyup',function(){
		if ($(this).val().length >= 5 && countUpperCase($(this).val()) > 90) 
			showError(this, 'El t&iacute;tulo no debe estar en may&uacute;sculas');
		else hideError(this);
	});
    // NO REPOST
    $('input[name=titulo]').blur(function(){
      var q = $(this).val();
		$.ajax({
			type: 'post',
			url: global_data.url + '/posts-genbus.php?do=search',
			data: 'q=' + q,
			success: function(h) {
            $('#repost').html(h);
			}
		});
    });
    // GENERADOR DE TAGS
    $('input[name=tags]').click(function(){
      if(tags == true) return true;
      var q = $('input[name=titulo]').val();
		$.ajax({
			type: 'post',
			url: global_data.url + '/posts-genbus.php?do=generador',
			data: 'q=' + q,
			success: function(h) {
            $('input[name=tags]').val(h);
            tags = true;
			}
		});
   });
	// PUBLICAR POST DIRECTAMENTE
	$('#vista_previa').on('click',function(e){
		//COMPROBAR TITULO
		var titulo = $('input[name=titulo]').val();
		if (titulo.length < 1) {
			showError($('input[name=titulo]').get(0), 'Debes ingresar un titulo para el post');
			$('input[name=titulo]').focus();
			return false;
		}
		//COMPROBAR CONTENIDO
		var cuerpo = $('textarea[name=cuerpo]').bbcode();
		if (cuerpo.length < 1) {
			showError($('textarea[name="cuerpo"]').get(0), 'Ingresa contenido para el post');
			$('textarea[name="cuerpo"]').focus();
			return false;
		}		
		//COMPROBAR CATEGORIA
		var categoria = $('select[name=categoria]').val();
		if (!categoria) {
			showError($('select[name=categoria]').get(0), 'Selecciona una categor&iacute;a');
			return false;
		}		
		//COMPROBAR TAGS
		var tags = $('input[name=tags]').val().split(',');
		if (tags.length < 4) {
			showError($('input[name=tags]').get(0), 'Tienes que ingresar por lo menos 4 tags separados por coma.');
			return false;
		} else {
			for(var i = 0; i < tags.length; i++){
				if(tags[i] == '') {
					showError($('input[name=tags]').get(0), 'Tienes que ingresar por lo menos 4 tags separados por coma.');
					return false;
				} else hideError($('input[name=tags]').get(0));
			}
		}
		//GUARDAR POST DESPUES DE COMPROBAR CAMPOS
		postSave();
	});
   //
   $('#publicar').on('click',function(){
		//COMPROBAR TITULO
		var titulo = $('input[name=titulo]').val();
		if (titulo.length < 1) {
			showError($('input[name=titulo]').get(0), 'Debes ingresar un titulo para el post');
			$('input[name=titulo]').focus();
			return false;
		}
		//COMPROBAR CONTENIDO
		var cuerpo = $('textarea[name=cuerpo]').bbcode();
		if (cuerpo.length < 1) {
			showError($('textarea[name="cuerpo"]').get(0), 'Ingresa contenido para el post');
			$('textarea[name="cuerpo"]').focus();
			return false;
		}				
		mydialog.show(true);
		mydialog.title(titulo);
		mydialog.body('<div class="carf"><p>Cargando vista previa</p></div>');
      mydialog.buttons(false);
		mydialog.center();
       
      // PREVIEW
		$.ajax({
			type: 'post',
			url: global_data.url + '/posts-preview.php?ts=true',
			data: 'titulo=' + encodeURIComponent($('input[name=titulo]').val()) + 
			'&cuerpo=' + encodeURIComponent($('textarea[name=cuerpo]').bbcode()),
			success: function(r) {
				mydialog.body(r);
				mydialog.buttons(true, true, 'Cerrar', 'close', true, false);
				mydialog.center();
				ScrollToMin(0, 500)
			}
		});	
	});
});
//
function postSave() {
	mydialog.show(true);
	mydialog.title('Publicando');
	mydialog.body('<div class="carf"><p>Comprobando contenido</p></div>');
	mydialog.buttons(false);
	mydialog.center();
			
	confirm = false;
	$('form[name=newpost]').submit();
}

$(document).ready(function(){
	$('#GeneratorBtn').on('click', function(){
		var html = '';
		html += '<h4>Que tipo de post vas a crear?</h4><br>';
		html += '<div class="row">';
		html += '<div class="col-sm-4"><a onclick="wysibb_generate(1);" class="d-block btn btn-primary">Normal</a></div>';
		html += '<div class="col-sm-4"><a onclick="wysibb_generate(2);" class="d-block btn btn-primary">Juego</a></div>';
		html += '<div class="col-sm-4"><a onclick="wysibb_generate(3);" class="d-block btn btn-primary">Pelicula</a></div>';
		html += '</div>';
		mydialog.show(true);
		mydialog.title('Generador de post!');
		mydialog.body(html);
		mydialog.buttons(false);
		mydialog.center();
	});
	$('#Aplicar').on('click', function(){
		$(this).addClass('loading');
		setTimeout(function(){ 
			InsertInfoPost();
   		$('#Aplicar').removeClass('d-block');
   		$('#GeneratorBtn').addClass('d-block');
   		$('#GeneratorBtn, #Aplicar').slideToggle();
   		$('#generator').remove();
   		$('#contentPosts').css('display', 'block');
		}, 1000);
	});
	print_editor();
});
function wysibb_generate(gpost) {
	switch (gpost) {
      case 1: var tipo = 'normal'; break;
      case 2: var tipo = 'juegos';  break;
      case 3: var tipo = 'peliculas'; break;
   }
   $.ajax({
   	type: 'POST',
   	url: global_data.url + '/generador-'+tipo+'.php',
   	success: function(h) {
   		$('#Aplicar').addClass('d-block');
   		$('#GeneratorBtn').removeClass('d-block');
   		$('#GeneratorBtn, #Aplicar').slideToggle();
   		$('#generator').html(h);
   		$('#contentPosts').css('display', 'none');
   		mydialog.close();
   	}
   });
}
function InsertInfoPost() {
	var txt = "", 
	markitup = document.querySelector(".wysibb-body").value;
	markitup = '';
	
	if ( $("#duracion").length ) {
		// Información de la película
		if (document.getElementById("duracion").value != "" || document.getElementById("estreno").value != "" || document.getElementById("generos").value != "" || document.getElementById("calidad").value != "" || document.getElementById("audio").value != ""){
			txt += '[info-movie]';
			var InfoMovies = ['duracion', 'estreno', 'generos', 'calidad', 'audio'];
			InfoMovies.forEach(function(InfoMovie, index) {
		   	let typename = $("#" + InfoMovie).val(), attr = $("#" + InfoMovie).attr('data-type');
		   	if(typename != "") txt += '[item]' + attr + ': [b]' + typename + '[/b][/item]';
			});
			txt += '[/info-movie]';
			txt += "\n";
			markitup += txt;
		}
	}
	// Sinopsis de la pelicula
	if (document.getElementById("contenent_body").value != ""){
	   txt += "[size=18][b][u]" + $("#contenent_body").attr('data-type') + "[/u]: [/b][/size]\n";
	   txt += $("#contenent_body").val(); 
	   txt += "\n\n";
		markitup += txt;
	}
	if ( $("#plataforma").length ) {
		// Ficha técnica para los juegos
		if (document.getElementById("plataforma").value != "" || document.getElementById("pesototal").value != "" || document.getElementById("formato").value != "" || document.getElementById("fechaestreno").value != "" || document.getElementById("fechaactualizacion").value != ""){
		   txt += "[size=18][b][u]FICHA TECNICA[/u]: [/b][/size]\n"; 
			var InfoGames = ['plataforma', 'pesototal', 'formato', 'idiomas', 'generosg', 'fechaestreno', 'fechaactualizacion'];
			InfoGames.forEach(function(InfoGame, index) {
		   	let typename = $("#" + InfoGame).val(), attr = $("#" + InfoGame).attr('data-type');
		   	if(typename != "") txt += attr + ': [b]' + typename + '[/b]\n'; 
			});
		   txt += "\n\n";
			markitup += txt;
		}
	}
	// Trailer para juegos, peliculas o simplemente videos
	if (document.getElementById("youtube").value != ""){
	   txt += "[trailer]trailer[/trailer][align=center]";
	   txt += "[video=https://www.youtube.com/v/";
	   txt += $("#youtube").val(); 
	   txt += "][/align]\n";
		markitup += txt;
	}
	if ( $("#os1").length ) {
		// Requisitos para poder instalar el juego sin problemas
		const Si_1 = document.getElementById("os1").value != "" || document.getElementById("procesador1").value != "" || document.getElementById("memoriaram1").value != "" || document.getElementById("graficos1").value != "" || document.getElementById("almacenamiento1").value != "" || document.getElementById("direcxt1").value != "",
		Si_2 = document.getElementById("os2").value != "" || document.getElementById("procesador2").value != "" || document.getElementById("memoriaram2").value != "" || document.getElementById("graficos2").value != "" || document.getElementById("almacenamiento2").value != "" || document.getElementById("direcxt2").value != "";
		if (Si_1 || Si_2) {
		   txt += "[size=18][b][u]REQUISITOS DEL SISTEMA[/u]: [/b][/size]\n"; 
		   if(Si_1) {
			   txt += "[b]MÍNIMOS: [/b]\n";
			   var InfoRequirements1 = ['os1', 'procesador1', 'memoriaram1', 'graficos1', 'almacenamiento1', 'direcxt1'];
				InfoRequirements1.forEach(function(InfoReq1, index) {
			   	let typename = $("#" + InfoReq1).val(), attr = $("#" + InfoReq1).attr('placeholder');
			   	if(typename != "") txt += attr + ': [b]' + typename + '[/b]\n'; 
				});
			   txt += "\n";
			}
		   if(Si_2) {
		   	txt += "[b]RECOMENDADOS: [/b]\n";
		   	var InfoRequirements2 = ['os2', 'procesador2', 'memoriaram2', 'graficos2', 'almacenamiento2', 'direcxt2'];
		   	InfoRequirements2.forEach(function(InfoReq2, index) {
		   	   let typename = $("#" + InfoReq2).val(), attr = $("#" + InfoReq2).attr('placeholder');
		   	   if(typename != "") txt += attr + ': [b]' + typename + '[/b]\n'; 
		   	});	   
		   	txt += "\n";
		   }
			markitup += txt;
		}
	}
	// Capturas del juego o de la pelicula, o simplemente imagenes al azar
	if (document.getElementById("slideimg").value != "") {
	   const list_link = $('#slideimg').val(), separate = list_link.split(';');
	   txt += "[capturas]capturas[/capturas][thumbnails]";
	   separate.forEach(function(linkofimage) {
	   	var enlace = linkofimage.trim();
	   	txt += "[img="+enlace+"]";
	   });
	   txt += "[/thumbnails]\n";
		markitup += txt;
	}
	// Enlaces de descargas, servidores, links
	if (document.getElementById("downlinks").value != ""){
	   const download_list = $('#downlinks').val(), separate = download_list.split(';');
	   txt += "[descargas]descargas[/descargas][align=center]";
	   separate.forEach(function(descargas, index) {
	   	var enlace = descargas.trim(), id = index+1;
	   	txt += "[url="+enlace+"]Enlace [b]N°"+id+"[/b][/url]\n";
	   });
	   txt += "[/align]\n";
		markitup += txt;
	}
	if ( $("#password").length ) {
		// En el caso que el archivo posea contraseña para descomprimir
		if (document.getElementById("password").value != "") {
		   txt += "[b][u]CONTRASEÑA DEL ARCHIVO: [/u][/b]\n[align=center]";
		   txt += $("#password").val();
		   txt += "[/align]\n";
			markitup += txt;
		}
	}
	// Agregamos todo al post!
	document.querySelector(".wysibb-body").append(txt);
}