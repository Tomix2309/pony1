/* Box login */
function open_login_box(action) {
   if ($('.backLogin').css('display') == 'block' && action != 'open') close_login_box();
   else {
      $('#login_error, #login_cargando').css('display', 'none');
      $('.opciones_usuario').addClass('here');
      $('.backLogin').fadeIn('fast');
      $('#nickname').focus();
   }
}
function close_login_box() {
   $('.opciones_usuario').removeClass('here');
   $('.backLogin').slideUp('fast');
}

function ir_a_categoria(cat) {
   if (cat != 'root' && cat != 'linea')
      if (cat == -1) document.location.href = global_data.url + '/';
      else if (cat == -2) document.location.href = global_data.url + '/' + 'posts/';
   else document.location.href = global_data.url + '/' + 'posts' + '/' + cat + '/';
}
function ScrollToMin(stm, sbm) {
   var scroll = window.scrollTo(stm, sbm);
   return scroll;
}
function ibuscador_intro(e) {
   tecla = (document.all) ? e.keyCode : e.which;
   if (tecla == 13) home_search();
}

function home_search() {
   if ($('#ibuscadorq').val() == '' || $('#ibuscadorq').val() == $('#ibuscadorq').attr('title')) {
      $('#ibuscadorq').focus();
      return;
   }
}
function buscar_en_web(open) {
	if(open == 3) {
		$('.nav-search input').toggleClass('open', 'closed');
		$('.nav-search input').on("keyup", function(){
			var letter = $(this).val();
			$.ajax({
				type: 'POST',
				url: global_data.url + '/buscador-buscar.php',
				data: 'word=' + letter,
				success: function(h) {
					$('#results').addClass('shadow rounded').html(h);
				}
			});
		});
	} else location.href = global_data.url + '/buscador/';	
}
function cerrarBus() {
	$(this).on('click', function(){
		$('#results').removeClass('shadow rounded').html('');
	});
}
/* FIN - Buscador Home */

/* FIN - Editor */
function gget(data, sin_amp) {
   var r = data + '=';
   if (!sin_amp) r = '&' + r;
   switch (data) {
      case 'key':
         if (global_data.user_key != '') return r + global_data.user_key;
      break;
      case 'postid':
         if (global_data.postid != '') return r + global_data.postid;
      break;
      case 'fotoid':
         if (global_data.fotoid != '') return r + global_data.fotoid;
      break;
      case 'temaid':
         if (global_data.temaid != '') return r + global_data.temaid;
      break;
   }
   return '';
}

function keypress_intro(e) {
   tecla = (document.all) ? e.keyCode : e.which;
   return (tecla == 13);
}

function onfocus_input(o) {
   if ($(o).val() == $(o).attr('title')) {
      $(o).val('');
      $(o).removeClass('onblur_effect');
   }
}

function onblur_input(o) {
   if ($(o).val() == $(o).attr('title') || $(o).val() == '') {
      $(o).val($(o).attr('title'));
      $(o).addClass('onblur_effect');
   }
}
function bloquear(user, bloqueado, lugar, aceptar) {
   if (!aceptar && bloqueado) {
      mydialog.show();
      mydialog.title('Bloquear usuario');
      mydialog.body('&iquest;Realmente deseas bloquear a este usuario?');
      mydialog.buttons(true, true, 'SI', "bloquear('" + user + "', true, '" + lugar + "', true)", true, false, true, 'NO', 'close', true, true);
      mydialog.center();
      return;
   }
   if (bloqueado) mydialog.procesando_inicio('Procesando...', 'Bloquear usuario');
   $('#loading').fadeIn(250);
   $.ajax({
      type: 'POST',
      url: global_data.url + '/bloqueos-cambiar.php',
      data: 'user=' + user + (bloqueado ? '&bloquear=1' : '') + gget('key'),
      success: function(h) {
         mydialog.alert('Bloquear Usuarios', h.substring(3));
         //
         if (h.charAt(0) == 1) {
            switch (lugar) {
               case 'perfil':
                  if (bloqueado) $('#bloquear_cambiar').html('Desbloquear').removeClass('btn-gradient-three').addClass('btn-gradient-five').attr('href', "javascript:bloquear('" + user + "', false, '" + lugar + "')");
                  else $('#bloquear_cambiar').html('Bloquear').removeClass('btn-gradient-five').addClass('btn-gradient-three').attr('href', "javascript:bloquear('" + user + "', true, '" + lugar + "')");
               break;
               case 'respuestas':
               case 'comentarios':
                  if (bloqueado) {
                     $('li.desbloquear_' + user).show();
                     $('li.bloquear_' + user).hide();
                  } else {
                     $('li.bloquear_' + user).show();
                     $('li.desbloquear_' + user).hide();
                  }
                  break;
               case 'mis_bloqueados':
                  if (bloqueado) $('.bloquear_usuario_' + user).attr('title', 'Desbloquear Usuario').removeClass('bloqueadosU').addClass('desbloqueadosU').html('Desbloquear').attr('href', "javascript:bloquear('" + user + "', false, '" + lugar + "')");
                  else $('.bloquear_usuario_' + user).attr('title', 'Bloquear Usuario').removeClass('desbloqueadosU').addClass('bloqueadosU').html('Bloquear').attr('href', "javascript:bloquear('" + user + "', true, '" + lugar + "')");
                  break;
               case 'mensajes':
                  if (bloqueado) $('#bloquear_cambiar').html('Desbloquear').attr('href', "javascript:bloquear('" + user + "', false, '" + lugar + "')");
                  else $('#bloquear_cambiar').html('Bloquear').attr('href', "javascript:bloquear('" + user + "', true, '" + lugar + "')");
                  break;
            }
         }
         $('#loading').fadeOut(350);
      },
      error: function() {
         mydialog.error_500("bloquear('" + user + "', '" + bloqueado + "', '" + lugar + "', true)");
         $('#loading').fadeOut(350);
      },
      complete: function() {
         mydialog.procesando_fin();
         $('#loading').fadeOut(350);
      }
   });
}

/* MyDialog */
var mydialog = {
   is_show: false,
   class_aux: '',
   mask_close: true,
   close_button: false,
   show: function(class_aux){
      if(this.is_show) return;
      else this.is_show = true;
      const SyntaxisLite = `<div id="dialog">
         <div id="title"></div>
         <div id="cuerpo">
            <div id="procesando"><div id="mensaje"></div></div>
            <div id="modalBody"></div>
            <div id="buttons" class="d-flex justify-content-between align-items-center w-100"></div>
         </div>
      </div>`;
      if($('#mydialog').html() == '') {
         $('#mydialog').html(SyntaxisLite).css('display', 'flex');
         $('#body').addClass('modal-open');
      }
   
      if(class_aux==true) $('#mydialog').addClass(this.class_aux);
      else if(this.class_aux != ''){
         $('#mydialog').removeClass(this.class_aux);
         this.class_aux = '';
      }
   
      if(this.close_button) $('#mydialog #dialog').append('<svg onclick="mydialog.close()" id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M2 30 L30 2 M30 30 L2 2" /></svg>');
      else $('#mydialog #dialog .close_dialog').remove();
   
      $('#mydialog #dialog').fadeIn('fast');
   },
   close: function(){
      //Vuelve todos los parametros por default
      this.class_aux = '';
      this.mask_close = true;
      this.close_button = false;
      this.is_show = false;
      $('#mydialog').css('display', 'none');
      $('#mydialog #dialog').fadeOut('fast', function(){ $(this).remove() });
      $('#body').removeClass('modal-open');
      this.procesando_fin();
   },
   center: function() {
   },
   title: function(title) {
      $('#mydialog #title').html(title);
   },
   body: function(body, width, height) {
      $('#mydialog #modalBody').html(body);
   },
   buttons: function(display_all, btn1_display, btn1_val, btn1_action, btn1_enabled, btn1_focus, btn2_display, btn2_val, btn2_action, btn2_enabled, btn2_focus) {
      if (!display_all) {
         $('#mydialog #buttons').css('display', 'none').html('');
         return;
      }
      if (btn1_action == 'close') btn1_action = 'mydialog.close()';
      if (btn2_action == 'close' || !btn2_val) btn2_action = 'mydialog.close()';
      if (!btn2_val) {
         btn2_val = 'Cancelar';
         btn2_enabled = true;
      }
      var html = '';
      if (btn1_display) html += '<input type="button" class="btn btn-success' + (btn1_enabled ? '' : ' disabled') + '" style="display:' + (btn1_display ? 'inline-block' : 'none') + '"' + (btn1_display ? ' value="' + btn1_val + '"' : '') + (btn1_display ? ' onclick="' + btn1_action + '"' : '') + (btn1_enabled ? '' : ' disabled') + ' />';
      if (btn2_display) html += ' <input type="button" class="btn btn-danger' + (btn1_enabled ? '' : ' disabled') + '" style="display:' + (btn2_display ? 'inline-block' : 'none') + '"' + (btn2_display ? ' value="' + btn2_val + '"' : '') + (btn2_display ? ' onclick="' + btn2_action + '"' : '') + (btn2_enabled ? '' : ' disabled') + ' />';
      $('#mydialog #buttons').html(html).css('display', 'inline-block');
      if (btn1_focus) $('#mydialog #buttons .btn.btn-success').focus();
      else if (btn2_focus) $('#mydialog #buttons .btn.btn-danger').focus();
   },
   alert: function(title, body, reload) {
      this.show();
      this.title(title);
      this.body(body);
      this.buttons(true, true, 'Aceptar', 'mydialog.close();' + (reload ? 'location.reload();' : 'close'), true, true, false);
      this.center();
   },
   error_500: function(fun_reintentar) {
      setTimeout(function() {
         mydialog.procesando_fin();
         mydialog.show();
         mydialog.title('Error');
         mydialog.body('Error al intentar procesar lo solicitado');
         mydialog.buttons(true, true, 'Reintentar', 'mydialog.close();' + fun_reintentar, true, true, true, 'Cancelar', 'close', true, false);
         mydialog.center();
      }, 200);
   },
   procesando_inicio: function(value, title) {
      if (!this.is_show) {
         this.show();
         this.title(title);
         this.body('');
         this.buttons(false, false);
         this.center();
      }
      title = empty(title) ? '' : '<span>'+title+'</span>';
      $('#mydialog #procesando #mensaje').html('<span class="d-block postition-relative text-center loading loading-lg success"></span>' + title);
      $('#mydialog #procesando').addClass('load').fadeIn('fast');
   },
   procesando_fin: function() {
      $('#mydialog #procesando').removeClass('load').fadeOut('fast');
   }
};
document.onkeydown = function(e) {
   key = (e == null) ? event.keyCode : e.which;
   if (key == 27) //escape, close mydialog
      mydialog.close();
};


$(document).ready(function() {
   $('body').on('click', e => {
      if ($('#mon_list').css('display') != 'none' && $(e.target).closest('#mon_list').length == 0 && $(e.target).closest('a[name=Monitor]').length == 0) notifica.last();
      if ($('#mp_list').css('display') != 'none' && $(e.target).closest('#mp_list').length == 0 && $(e.target).closest('a[name=Mensajes]').length == 0) mensaje.last();
      if ($('#menu_list').css('display') != 'none' && $(e.target).closest('#menu_list').length == 0 && $(e.target).closest('a[name=Menu]').length == 0) menu.last();
   });
});
var notifica = {
   cache: {},
   retry: Array(),
   userMenuPopup: function(obj) {
      var id = $(obj).attr('userid');
      var cache_id = 'following_' + id,
         list = $(obj).children('ul');
      $(list).children('li.check').slideUp();
      if (this.cache[cache_id] == 1) {
         $(list).children('li.follow').slideUp();
         $(list).children('li.unfollow').slideDown();
      } else {
         $(list).children('li.unfollow').slideUp();
         $(list).children('li.follow').slideDown();
      }
   },
   userInMencionHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         var fid = x[1];
         $('a.mf_' + fid + ', a.mf_' + fid).each(function() {
            $(this).toggle();
         });
         $('.mft_' + fid).html(number_format(parseInt(x[2])));
         vcard_cache['mf' + fid] = '';
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   userMenuHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         var cache_id = 'following_' + x[1];
         notifica.cache[cache_id] = parseInt(x[0]);
         $('div.avatar-box').children('ul').hide();
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[4]);
   },
   userInPostHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         $('a.follow_user_post, a.unfollow_user_post').toggle();
         $('div.metadata-usuario > span.nData.user_follow_count').html(number_format(parseInt(x[2])));
         notifica.userMenuHandle(r);
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   userInMonitorHandle: function(r, obj) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) $(obj).fadeOut(function() {
         $(obj).remove();
      });
      else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   inPostHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         $('a.follow_post, a.unfollow_post').parent('li').toggle();
         $('ul.post-estadisticas > li > span.icons.monitor').html(number_format(parseInt(x[2])));
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   inComunidadHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         $('a.follow_comunidad, a.unfollow_comunidad').toggle();
         $('li.comunidad_seguidores').html(number_format(parseInt(x[2])) + ' Seguidores');
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   temaInComunidadHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         $('div.followBox > a.follow_tema, a.unfollow_tema').toggle();
         $('span.tema_notifica_count').html(number_format(parseInt(x[2])) + ' Seguidores');
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   ruserInAdminHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) $('.ruser' + x[1]).toggle();
      else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   listInAdminHandle: function(r) {
      var x = r.split('-');
      if (x.length == 3 && x[0] == 0) {
         $('.list' + x[1]).toggle();
         $('.list' + x[1] + ':first').parent('div').parent('li').children('div:first').fadeTo(0, $('.list' + x[1] + ':first').css('display') == 'none' ? 0.5 : 1);
      } else if (x.length == 4) mydialog.alert('Notificaciones', x[3]);
   },
   spamPostHandle: function(r) {
      var x = r.split('-');
      if (x.length == 2) mydialog.alert('Notificaciones', x[1]);
      else mydialog.close();
   },
   spamTemaHandle: function(r) {
      var x = r.split('-');
      if (x.length == 2) mydialog.alert('Notificaciones', x[1]);
      else mydialog.close();
   },
   ajax: function(param, cb, obj) {
      if ($(obj).hasClass('spinner')) return;
      notifica.retry.push(param);
      notifica.retry.push(cb);
      var error = param[0] != 'action=count';
      $(obj).addClass('spinner');
      $('#loading').fadeIn(250);
      $.ajax({
         url: global_data.url + '/notificaciones-ajax.php',
         type: 'post',
         data: param.join('&') + gget('key'),
         success: function(r) {
            $(obj).removeClass('spinner');
            cb(r, obj);
            $('#loading').fadeOut(350);
         },
         error: function() {
            if (error) mydialog.error_500('notifica.ajax(notifica.retry[0], notifica.retry[1])');
            $('#loading').fadeOut(350);
         }
      });
   },
   follow: function(type, id, cb, obj) {
      this.ajax(Array('action=follow', 'type=' + type, 'obj=' + id), cb, obj);
   },
   unfollow: function(type, id, cb, obj) {
      this.ajax(Array('action=unfollow', 'type=' + type, 'obj=' + id), cb, obj);
   },
   spam: function(id, cb) {
      this.ajax(Array('action=spam', 'postid=' + id), cb);
   },
   c_spam: function(id, cb) {
      this.ajax(Array('action=c_spam', 'temaid=' + id), cb);
   },
   sharePost: function(id) {
      mydialog.show();
      mydialog.title('Recomendar');
      mydialog.body('¿Quieres recomendar este post a tus seguidores?');
      mydialog.buttons(true, true, 'Recomendar', 'notifica.spam(' + id + ', notifica.spamPostHandle)', true, true, true, 'Cancelar', 'close', true, false);
      mydialog.center();
   },
   shareTema: function(id) {
      mydialog.show();
      mydialog.title('Recomendar');
      mydialog.body('¿Quieres recomendar este tema a tus seguidores?');
      mydialog.buttons(true, true, 'Recomendar', 'notifica.c_spam(' + id + ', notifica.spamTemaHandle)', true, true, true, 'Cancelar', 'close', true, false);
      mydialog.center();
   },
   last: function() {
      var c = parseInt($('#alerta_mon > a > span').html());
      mensaje.close();
      if ($('#mon_list').css('display') != 'none') {
         $('#mon_list').fadeOut();
         $('a[name=Monitor]').parent('li').removeClass('monitor-notificaciones');
      } else {
         if (($('#mon_list').css('display') == 'none' && c > 0) || typeof notifica.cache.last == 'undefined') {
            $('#mon_list').slideDown();
            notifica.ajax(Array('action=last'), function(r) {
               notifica.cache['last'] = r;
               notifica.show();
            });
         } else notifica.show();
      }
   },
   check: function() {
      notifica.ajax(Array('action=count'), notifica.popup);
   },
   popup: function(r) {
      var c = parseInt($('#alerta_mon > a > span').html());
      if (r != c && r > 0) {
         if (r != 1) var not_total = ' notificaciones';
         else var not_total = ' notificaci&oacute;n';
         if (!$('#alerta_mon').length) $('div.nav-user > div.monitor').append('<div class="alertas" id="alerta_mon"><a title="' + r + not_total + '"><span></span></a></div>');
         $('#alerta_mon > a > span').html(r);
         $('#alerta_mon').animate({
            top: '-=5px'
         }, 100, null, function() {
            $('#alerta_mon').animate({
               top: '+=5px'
            }, 100)
         });
      } else if (r == 0) $('#alerta_mon').remove();
   },
   show: function() {
      if (typeof notifica.cache.last != 'undefined') {
         $('#alerta_mon').remove();
         $('#mon_list').show().children('ul').html(notifica.cache.last);
      }
   },
   filter: function(x, obj) {
      $.ajax({
         url: global_data.url + '/notificaciones-filtro.php',
         type: 'post',
         data: 'fid=' + x
      });
      var v = $(obj).prop('checked') ? 1 : 0;
   },
   close: function() {
      $('#mon_list').hide();
      $('a[name=Monitor]').parent('li').removeClass('monitor-notificaciones');
   }
}
/* Mensajes */
var mensaje = {
   cache: {},
   vars: Array(),
   // CREAR HTML
   form: function() {
      var html = '';
      if (this.vars['error']) html += '<div class="alert alert-warning">' + this.vars['error'] + '</div><br style="clear:both">'
      html += '<div class="form-group"><label class="form-label" for="msg_to">Para:</label>'
      html += '<input type="text" placeholder="Ingrese el nombre de usuario" class="form-input" value="' + this.vars['to'] + '" maxlength="16" tabindex="0" size="20" id="msg_to" name="msg_to"/></div>'
      html += '<div class="form-group"><label class="form-label" for="msg_subject">Asunto:</label>'
      html += '<input type="text" placeholder="Asunto del mensaje" class="form-input" value="' + this.vars['sub'] + '" maxlength="100" tabindex="0" size="50" id="msg_subject" name="msg_subject"/></div>'
      html += '<div class="form-group"><label class="form-label" for="msg_body">Mensaje:</label>'
      html += '<textarea tabindex="0" placeholder="El mensaje a enviar" rows="2" id="msg_body" name="msg_body" class="form-input">' + this.vars['msg'] + '</textarea></div>'
      return html;
   },
   // FUNCIONES AUX
   checkform: function(h) {
      if (parseInt(h) == 0) mensaje.enviar(1);
      else if (parseInt(h) == 1) {
         mensaje.nuevo(mensaje.vars['to'], mensaje.vars['sub'], mensaje.vars['msg'], 'No es posible enviarse mensajes a s&iacute; mismo.');
      } else if (parseInt(h) == 2) {
         mensaje.nuevo(mensaje.vars['to'], mensaje.vars['sub'], mensaje.vars['msg'], 'Este usuario no existe. Por favor, verif&iacute;calo.');
      }
   },
   alert: function(h) {
      mydialog.procesando_fin();
      mydialog.alert('Aviso', '<div class="alert alert-primary">' + h + '</div>');
   },
   mostrar: function(show, obj) {
      //
      $('.GBTabset a').removeClass('here');
      //
      if (show == 'all') {
         $('#mensajes div').show();
         $(obj).addClass('here');
      } else if (show == 'unread') {
         $('#mensajes div.GBThreadRow').hide();
         $('#mensajes table.unread').parent().show();
         $(obj).addClass('here');
      }
   },
   select: function(act) {
      //
      var inputs = $('#mensajes .GBThreadRow :input');
      inputs.each(function() {
         if (act == 'all') {
            $(this).attr({
               checked: 'checked'
            });
         } else if (act == 'read') {
            if ($(this).attr('class') != 'inread') {
               $(this).attr({
                  checked: 'checked'
               });
            } else $(this).attr({
               checked: ''
            });
         } else if (act == 'unread') {
            if ($(this).attr('class') == 'inread') {
               $(this).prop({checked: 'checked'});
            } else $(this).attr({
               checked: ''
            });
         } else if (act == 'none') {
            $(this).attr({
               checked: ''
            });
         }
      });
   },
   modificar: function(act) {
      var inputs = $('#mensajes .GBThreadRow :input');
      var ids = new Array();
      var i = 0;
      //
      inputs.each(function() {
         var este = $(this).prop('checked');
         //
         if (este != false) {
            // AGREGAR EL ID
            ids[i] = $(this).val();
            i++;
            // PARA LOS ESTILOS
            var cid = $(this).val().split(':');
            // MARCAR LEIDO
            if (act == 'read') {
               $('#' + cid[0]).removeClass('unread');
               $(this).removeClass('inread');
               // MARCAR NO LEIDO
            } else if (act == 'unread') {
               $('#' + cid[0]).addClass('unread');
               $(this).addClass('inread');
               // ELIMINAR
            } else if (act == 'delete') {
               $('#' + cid[0]).parent().remove();
            }
         }
      });
      // ENVIAR CAMBIOS
      if (ids.length > 0) {
         var params = ids.join(',');
         mensaje.ajax('editar', 'ids=' + params + '&act=' + act, function(r) {
            //
         });
      }
   },
   eliminar: function(id, type) {
      mensaje.ajax('editar', 'ids=' + id + '&act=delete', function(r) {
         if (type == 1) {
            var cid = id.split(':');
            $('#mp_' + cid[0]).remove();
         } else if (type == 2) {
            location.href = global_data.url + '/mensajes/';
         }
      });
   },
   marcar: function(id, a, type, obj) {
      var act = (a == 0) ? 'read' : 'unread';
      var show = (act == 'read') ? 'unread' : 'read';
      //
      mensaje.ajax('editar', 'ids=' + id + '&act=' + act, function(r) {
         // CAMBIAR ENTRE LEIDO Y NO LEIDO
         if (type == 1) {
            var cid = id.split(':');
            if (act == 'read') $('#mp_' + cid[0]).removeClass('unread');
            else $('#mp_' + cid[0]).addClass('unread');
            //
            $(obj).parent().find('a').hide();
            $(obj).parent().find('.' + show).show();
         } else {
            location.href = global_data.url + '/mensajes/';
         }
      });
   },
   // POST
   ajax: function(action, params, fn) {
      $('#loading').fadeIn(250);
      $.ajax({
         type: 'POST',
         url: global_data.url + '/mensajes-' + action + '.php',
         data: params,
         success: function(h) {
            fn(h);
            $('#loading').fadeOut(350);
         }
      });
   },
   // PREPARAR EL ENVIO
   nuevo: function(para, asunto, body, error) {
      // GUARDAR
      this.vars['to'] = para;
      this.vars['sub'] = asunto;
      this.vars['msg'] = body;
      this.vars['error'] = error;
      //
      mydialog.procesando_fin();
      mydialog.show(true);
      mydialog.title('Nuevo mensaje');
      mydialog.body(this.form());
      mydialog.buttons(true, true, 'Enviar', 'mensaje.enviar(0)', true, true, true, 'Cancelar', 'close', true, false);
      mydialog.center();
   },
   // ENVIAR...
   enviar: function(enviar) {
      // DATOS
      this.vars['to'] = $('#msg_to').val();
      this.vars['sub'] = $('#msg_subject').val();
      this.vars['msg'] = $('#msg_body').val();
      // COMPROBAR
      if (enviar == 0) { // VERIFICAR...
         if (this.vars['to'] == '') mensaje.nuevo(mensaje.vars['to'], mensaje.vars['sub'], mensaje.vars['msg'], 'Por favor, especific&aacute; el destinatario.');
         if (this.vars['msg'] == '') mensaje.nuevo(mensaje.vars['to'], mensaje.vars['sub'], mensaje.vars['msg'], 'El mensaje esta vac&iacute;o.');
         //
         mydialog.procesando_inicio('Verificando...', 'Nuevo Mensaje');
         this.ajax('validar', 'para=' + this.vars['to'], mensaje.checkform);
      } else if (enviar == 1) {
         mydialog.procesando_inicio('Enviando...', 'Nuevo Mensaje');
         // ENVIAR
         this.ajax('enviar', 'para=' + mensaje.vars['to'] + '&asunto=' + mensaje.vars['sub'] + '&mensaje=' + mensaje.vars['msg'], mensaje.alert);
      }
   },
   // RESPONDER
   responder: function(mp_id) {
      this.vars['mp_id'] = $('#mp_id').val();
      this.vars['mp_body'] = $('#respuesta').val();
      if (this.vars['mp_body'] == '') {
         $('#respuesta').focus();
         return;
      }
      //
      this.ajax('respuesta', 'id=' + this.vars['mp_id'] + '&body=' + this.vars['mp_body'], function(h) {
         $('#respuesta').val(''); // LIMPIAMOS
         $('.wysibb-body').html('');
         switch (h.charAt(0)) {
            case '0':
               mydialog.alert("Error", h.substring(3));
               break;
            case '1':
               $('#historial').append($(h.substring(3)).fadeIn('slow'));
               break;
         }
         $('#respuesta').focus();
      });
   },
   last: function() {
      var c = parseInt($('#alerta_mps > a > span').html());
      notifica.close();
      //
      if ($('#mp_list').css('display') != 'none') {
         $('#mp_list').hide();
         $('a[name=Mensajes]').parent('li').removeClass('monitor-notificaciones');
      } else {
         if (($('#mp_list').css('display') == 'none' && c > 0) || typeof mensaje.cache.last == 'undefined') {
            $('#mp_list').show();
            mensaje.ajax('lista', '', function(r) {
               mensaje.cache['last'] = r;
               mensaje.show();
            });
         } else mensaje.show();
      }
   },
   popup: function(mps) {
      var c = parseInt($('#alerta_mps > a > span').html());
      if (mps != c && mps > 0) {
         if (mps != 1) var mps_total = ' mensajes';
         else var mps_total = ' mensaje';
         if (!$('#alerta_mps').length) $('div.nav-user > div.mensajes').append('<div class="alertas" id="alerta_mps"><a title="' + mps + mps_total + '"><span></span></a></div>');
         $('#alerta_mps > a > span').html(mps);
         $('#alerta_mps').animate({
            top: '-=5px'
         }, 100, null, function() {
            $('#alerta_mps').animate({
               top: '+=5px'
            }, 100)
         });
      } else if (mps == 0) $('#alerta_mps').remove();
   },
   show: function() {
      if (typeof mensaje.cache.last != 'undefined') {
         $('#alerta_mps').remove();
         $('#mp_list').show().children('ul').html(mensaje.cache.last);
      }
   },
   close: function() {
      $('#mp_list').slideUp();
      $('a[name=Mensajes]').parent('li').removeClass('monitor-notificaciones');
   }
}

/* DENUNCIAS */
var denuncia = {
   nueva: function(type, obj_id, obj_title, obj_user){
      // PLANTILLA
		$('#loading').fadeIn(250); 
      $.ajax({
			type: 'POST',
			url: global_data.url + '/denuncia-' + type + '.php',
			data: 'obj_id=' + obj_id + '&obj_title=' + obj_title + '&obj_user=' + obj_user,
			success: function(h){
            denuncia.set_dialog(h, obj_id, type);
            $('#loading').fadeOut(350);                                 
			}
		});
   },
   set_dialog: function(html, obj_id, type){
      var d_title = 'Denunciar ' + type;
      // MYDIALOG
      mydialog.mask_close = false;
      mydialog.close_button = true;		                                        
		mydialog.show();
      mydialog.title(d_title);
		mydialog.body(html);
		mydialog.buttons(true, true, 'Enviar', "denuncia.enviar(" + obj_id + ", '" + type + "')", true, true, true, 'Cancelar', 'close', true, false);
		mydialog.center();
   },
   enviar: function(obj_id, type){
      var razon = $('select[name=razon]').val();
      var extras = $('textarea[name=extras]').val();
      //
      $('#loading').fadeIn(250);                         
		$.ajax({
			type: 'POST',
			url: global_data.url + '/denuncia-' + type + '.php',
			data: 'obj_id=' + obj_id + '&razon=' + razon + '&extras=' + extras,
			success: function(h){
            switch(h.charAt(0)){
               case '0':
                  mydialog.alert("Error",'<div class="alert alert-warning">' + h.substring(3) +  '</div>');
               break;
               case '1':
                  mydialog.alert("Bien", '<div class="alert alert-warning">' + h.substring(3) + '</div>');
               break;
            }
            $('#loading').fadeOut(350);                                                 
			}
		});
   }
}
/* AFILIACION */
var afiliado = {
   vars: Array(),
   nuevo: function(){
      // CARGAMOS Y BORRAMOS
      var form = '';
      form += '<div id="AFormInputs">'
      form += '<div class="form-group">'
      form += '<label class="form-label" for="atitle">T&iacute;tulo</label>'
      form += '<input type="text" tabindex="1" name="atitle" id="atitle" class="form-input" maxlength="35"/>'
  		form += '</div>'
      form += '<div class="form-group">'
      form += '<label class="form-label" for="aurl">Direcci&oacute;n</label>'
      form += '<input type="text" tabindex="2" name="aurl" id="aurl" class="form-input" value="https://"/>'
  		form += '</div>'
      form += '<div class="form-group">'
      form += '<label class="form-label" for="aimg">Banner <small>(216x42px)</small></label>'
      form += '<input type="text" tabindex="3" name="aimg" id="aimg" class="form-input" value="https://"/>'
  		form += '</div>'
      form += '<div class="form-group">'
      form += '<label class="form-label" for="atxt">Descripci&oacute;n</label>'
      form += '<textarea tabindex="4" rows="10" name="atxt" id="atxt" class="form-input" style="height:60px;"></textarea>'
  		form += '</div>'
      form += '</div>'
      //
      mydialog.class_aux = 'registro';
      mydialog.mask_close = false;
      mydialog.close_button = true;
		mydialog.show(true);
		mydialog.title('Nueva Afiliaci&oacute;n');
		mydialog.body(form);
		mydialog.buttons(true, true, 'Enviar', 'afiliado.enviar(0)', true, true, true, 'Cancelar', 'close', true, false);
		mydialog.center();
   },
   enviar: function(){
      var inputs = $('#AFormInputs :input');
      var status = true;
      var params = '';
      //
      inputs.each(function(){
         var val = $(this).val();
         // EL CAMPO AID NO ES NECESARIO
         if($(this).attr('name') == 'aID') val = '0'; 
         // COMPROBAMOS CAMPOS VACIOS
        	if(status == true) params += $(this).attr('name') + '=' + val + '&';
		});
      //
      if(status == true){
         mydialog.procesando_inicio('Enviando...', 'Nueva Afiliaci&oacute;n');
         afiliado.enviando(params);
      }
   },
   enviando: function(params){
   	//
      $('#loading').fadeIn(250); 
   	$.ajax({
   		type: 'POST',
   		url: global_data.url + '/afiliado-nuevo.php',
   		data: params,
   		success: function(h){
   		  	mydialog.procesando_fin();
   		  	switch(h.charAt(0)){
   		      case '0':
               	$('#AFStatus > span').fadeOut().text('La URL es incorrecta').fadeIn();
               break;
               case '1':
                  mydialog.body(h.substring(3));
                  mydialog.buttons(true, true, 'Aceptar', 'mydialog.close()', true, true);
               break;
               case '2':
               	$('#AFStatus > span').fadeOut().text('Faltan datos').fadeIn();
               break;
   		  	}
            mydialog.center();
            $('#loading').fadeOut(350); 
   		}
   	});
   },
   detalles: function(aid){
      $('#loading').fadeIn(250); 
   	$.ajax({
   		type: 'POST',
   		url: global_data.url + '/afiliado-detalles.php',
   		data: 'ref=' + aid,
   		success: function(h){
   		   mydialog.class_aux = '';
       		mydialog.show(true);
       		mydialog.title('Detalles');
       		mydialog.body(h);
            mydialog.buttons(true, true, 'Aceptar', 'mydialog.close()', true, true);
            mydialog.center();
            $('#loading').fadeOut(350); 
         }
   	});   
   }
}
var news = {
   total: 0,
   count: 1,
   slider: function(){
      if(news.total > 1){
         if(news.count < news.total) news.count++;
         else news.count = 1;
         //
         $('#top_news > li').hide();
         $('#new_' + news.count).fadeIn();
         // INFINITO :D
         setTimeout("news.slider()",7000);
      }
   }       
}
// READY
$(document).ready(function(){
   /* NOTICIAS */
   news.total = $('#top_news > li').length;
   news.slider();
   // Moderacion
   $('#stickymsg').on('onmouseover', function() {
      $('#brandday').css('opacity',0.5);
   }).on('onmouseout', function() {
      $('#brandday').css('opacity',1);
   }).on('onclick', function() {
   	var enlace = $(this).attr('data-url');
      location.href = enlace;
   });

   // Versión 1: Buscar usuarios [BETA]
   $('#buscarusuario input[name=usuario]').on('keyup', function(e){
		var usuario = $(this).val(), id = $(this).data('user');
		all = (usuario == 'all') ? 'todos' : usuario;
		$.ajax({
			type: 'POST',
			url: global_data.url + '/buscador-usuario.php',
			data: 'users=' + usuario + '&s=' + all + '&id=' + id,
			success: function(usuarios) {
				// Donde queremos visualizar el resultado!
				$('#resUser').html(usuarios);
			}
		});
   });

});

var menu = {
   cache: {},
   last: function() {
      //
      if ($('#menu_list').css('display') != 'none') $('#menu_list').hide();
      else {
         if (($('#menu_list').css('display') == 'none') || typeof favorito.cache.last == 'undefined') $('#menu_list').show();
      }
   },
   close: function(){
      $('#menu_list').slideUp();
   }
}
