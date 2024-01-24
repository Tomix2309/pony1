/* MODERACION */
var mod = {
   posts: {
      view: function(pid) {
         SL2.start();
         $.ajax({
            type: 'post',
            url: global_data.url + '/moderacion-posts.php?do=view',
            data: 'postid=' + pid,
            success: function(r) {
               mydialog.class_aux = 'preview';
               mydialog.show(true);
               mydialog.title('...');
               mydialog.body(r);
               mydialog.buttons(true, true, 'Cerrar', 'close', true, false);
               mydialog.center();
               SL2.stop();
            }
         });
      },
      ocultar: function(pid) {
         var text = $('#d_razon').val();
         if (text.length < 1) {
            mydialog.alert('Error', 'Introduzca una raz&oacute;n');
            text.focus();
            return;
         } else if (text.length > 50) {
            mydialog.alert('Error', 'La raz&oacute;n debe tener menos de 50 letras.');
            text.focus();
            return;
         } else {
            $.post(global_data.url + '/moderacion-posts.php?do=ocultar', 'razon=' + text + '&pid=' + pid, function(a) {
               mydialog.alert((a.charAt(0) == '0' ? 'Opps!' : 'Hecho'), a.substring(3), true);
               mydialog.center();
            });
         }
      },
      // BORRAR
      borrar: function(pid, redirect, aceptar) {
         if (!aceptar) {
            SL2.start();
            $.ajax({
               type: 'POST',
               url: global_data.url + '/moderacion-posts.php?do=borrar',
               success: function(h) {
                  mydialog.show();
                  mydialog.title('Borrar Post');
                  mydialog.body(h);
                  mydialog.buttons(true, true, 'Borrar', 'mod.posts.borrar(' + pid + ", '" + redirect + "', 1);", true, false, true, 'Cancelar', 'close', true, true);
                  $('#modalBody').css('padding', '20px 10px 0');
                  mydialog.center();
                  SL2.stop();
                  return;
               }
            });
         } else {
            mydialog.procesando_inicio('Eliminando...', 'Borrar Post');
            var razon = $('#razon').val()
            var razon_desc = $('input[name=razon_desc]').val();

            if ($('#send_b').attr('checked')) {
               var send_b = 'yes';
            }
            SL2.start();
            $.ajax({
               type: 'POST',
               url: global_data.url + '/moderacion-posts.php?do=borrar',
               data: 'postid=' + pid + '&razon=' + razon + '&razon_desc=' + razon_desc + '&send_b=' + send_b,
               success: function(h) {
                  switch (h.charAt(0)) {
                     case '0': //Error
                        mydialog.alert('Error', h.substring(3));
                        break;
                     case '1':
                        if (redirect == 'true') mod.redirect("/moderacion/posts", 1200);
                        else if (redirect == 'posts') {
                           mydialog.alert('Aviso', h.substring(3));
                           mod.redirect("/posts/", 2000);
                        } else {
                           mydialog.close();
                           $('#report_' + pid).slideUp();
                        }
                        break;
                  }
                  SL2.stop();
               },
               complete: function() {
                  mydialog.procesando_fin();
                  SL2.stop();
               }
            });
         }
      },
   },
   reboot: function(id, type, hdo, redirect) {
      SL2.start();
      $.ajax({
         type: 'post',
         url: global_data.url + '/moderacion-' + type + '.php?do=' + hdo,
         data: 'id=' + id,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0':
                  mydialog.alert("Error", h.substring(3));
                  break;
               case '1':
                  mydialog.alert("Aviso", '<div class="dialog_box">' + h.substring(3) + '</div>');
                  $('#report_' + id).fadeOut();
                  if (redirect)
                     if (redirect) mod.redirect("/moderacion/" + type, 1200);
                     else $('#report_' + id).slideUp();
                  break;
            }
            SL2.stop();
         }
      });
   },
   redirect: function(url_ref, time) {
      setTimeout(function() {
         document.location.href = global_data.url + url_ref;
      }, time)
   }
}
/* Eliminar Comentario */
function borrar_com(comid, autor, postid, gew) {
   mydialog.close();
   if (!postid) var postid = gget('postid');
   if (!gew) {
      mydialog.show();
      mydialog.title('Borrar Comentarios');
      mydialog.body('&#191;Quiere eliminar este comentario?');
      mydialog.buttons(true, true, 'S&iacute;', 'borrar_com(' + comid + ', ' + autor + ', ' + postid + ', 1)', true, false, true, 'No', 'close', true, true);
      mydialog.center();
   } else {
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/comentario-borrar.php',
         data: 'comid=' + comid + '&autor=' + autor + '&postid=' + postid,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error', h.substring(3));
                  break;
               case '1':
                  // RESTAMOS
                  var ncomments = parseInt($('#ncomments').text());
                  $('#ncomments').text(ncomments - 1);
                  //
                  $('#div_cmnt_' + comid).slideUp(1500, 'easeInOutElastic');
                  $('#div_cmnt_' + comid).slideUp('normal', function() {
                     $(this).remove();
                  });
                  SL2.stop();
                  break;
            }
         },
         error: function() {
            mydialog.error_500("borrar_com('" + comid + "')");
            SL2.stop();
         }
      });
   }
}
/* Ocultar Comentario */
function ocultar_com(comid, autor, postid) {
   mydialog.close();
   SL2.start();
   $.ajax({
      type: 'POST',
      url: global_data.url + '/comentario-ocultar.php',
      data: 'comid=' + comid + '&autor=' + autor + '&post_id=' + postid + gget('postid'),
      success: function(h) {
         switch (h.charAt(0)) {
            case '0': //Error
               mydialog.alert('Error', h.substring(3));
               break;
            case '1':
               $('#comentario_' + comid).css('opacity', 1);
               $('#pp_' + comid).css('opacity', 0.5);
               break;
            case '2':
               $('#comentario_' + comid).css('opacity', 0.5);
               $('#pp_' + comid).css('opacity', 1);
               break;
         }
         SL2.stop();
      },
      error: function() {
         mydialog.error_500("borrar_com('" + comid + "')");
      }
   });
}
/* Borrar Post */
function borrar_post(aceptar) {
   if (!aceptar) {
      mydialog.show();
      mydialog.title('Borrar Post');
      mydialog.body('&iquest;Seguro que deseas borrar este post?');
      mydialog.buttons(true, true, 'SI', 'borrar_post(1)', true, false, true, 'NO', 'close', true, true);
      mydialog.center();
      return;
   } else if (aceptar == 1) {
      mydialog.show();
      mydialog.title('Borrar Post');
      mydialog.body('Te pregunto de nuevo... &iquest;Seguro que deseas borrar este post?');
      mydialog.buttons(true, true, 'SI', 'borrar_post(2)', true, false, true, 'NO', 'close', true, true);
      mydialog.center();
      return;
   }
   mydialog.procesando_inicio('Eliminando...', 'Borrar Post');
   SL2.start();
   $.ajax({
      type: 'POST',
      url: global_data.url + '/posts-borrar.php',
      data: gget('postid', true),
      success: function(h) {
         switch (h.charAt(0)) {
            case '0': //Error
               mydialog.alert('Error', h.substring(3));
               break;
            case '1':
               mydialog.alert('Post Borrado', h.substring(3), true);
               break;
         }
         SL2.stop();
      },
      error: function() {
         mydialog.error_500("borrar_post(2)");
         SL2.stop();
      },
      complete: function() {
         mydialog.procesando_fin();
         SL2.stop();
      }
   });
}
/* Votar post */
function votar_post(puntos) {
   SL2.start();
   $.ajax({
      type: 'POST',
      //url: global_data.url + '/posts-votar.php',
      data: 'puntos=' + puntos + gget('postid'),
      success: function(h) {
         switch (h.charAt(0)) {
            case '0': //Error
               $('.stars').addClass('alert alert-danger').html(h.substring(3)).slideDown();
            break;
            case '1': //OK
               $('.stars').addClass('alert alert-success').html(h.substring(3)).slideDown();
               var num = number_format(parseInt($('.calificacion-foot .total').html().replace(".", "")) + 1, 0, ',', '.');
               $('.calificacion-foot .total').html(num);
            break;
         }
         SL2.stop();
      },
      error: function() {
         mydialog.error_500("votar_post('" + puntos + "')");
         SL2.stop();
      }
   });
}
/* Agregar post a favoritos */
var add_favoritos_agregado = false;

function add_favoritos() {
   if (add_favoritos_agregado) return;
   if (!gget('key')) {
      mydialog.alert('Login', 'Tienes que estar logueado para realizar esta operaci&oacute;n');
      return;
   }
   add_favoritos_agregado = true;
   SL2.start();
   $.ajax({
      type: 'POST',
      url: global_data.url + '/favoritos-agregar.php',
      data: gget('postid', true),
      success: function(h) {
         switch (h.charAt(0)) {
            case '0': //Error
               $('.post-metadata .mensajes').addClass('alert alert-danger').html(h.substring(3)).slideDown();
               break;
            case '1': //OK
               $('.post-metadata .mensajes').addClass('alert alert-success').html(h.substring(3)).slideDown();
               $('.favoritos_post').html(number_format(parseInt($('.favoritos_post').html().replace(".", "")) + 1, 0, ',', '.'));
               break;
         }
         SL2.stop();
      },
      error: function() {
         add_favoritos_agregado = false;
         mydialog.error_500("add_favoritos()");
         SL2.stop();
      }
   });
}

function print_editor() {
   //Editor de posts comentarios
   if ($('#body_comm').length && !$('.wysibb-texarea').length) {
      var wbbOpt = {
         buttons: "smilebox,|,bold,italic,underline,|,img,link"
      }
      $('#body_comm').removeAttr('onblur onfocus class style title').css('height', '80').html('').wysibb(wbbOpt);
   }
}
print_editor();
/* extras */
function emoticones() {
   var winpops = window.open(global_data.url + "/emoticones.php", "", "width=180px,height=500px,scrollbars,resizable");
}
/* COMENTARIOS */
var comentario = {
   /* VARIABLES */
   cache: {},
   cargado: false,
   /* FUNCIONES */
   cargar: function(postid, page, autor) {
      // GIF
      $('#com_gif').show();
      //window.scrollTo('#comentarios-container', 250);
      $('div#comentarios').css('opacity', 0.4)
      // COMPRVAMOS CACHE
      if (typeof comentario.cache['c_' + page] == 'undefined') {
         SL2.start();
         $.ajax({
            type: 'POST',
            url: global_data.url + '/comentario-ajax.php?page=' + page,
            data: 'postid=' + postid + '&autor=' + autor,
            success: function(h) {
               comentario.cache['c_' + page] = h;
               $('#comentarios').html(h);
               comentario.set_pages(postid, page, autor);
               SL2.stop();
            }
         });
      } else {
         $('#comentarios').html(comentario.cache['c_' + page]);
         $('.paginadorCom').html(comentario.cache['p_' + page]);
         $('#com_gif').hide();
         $('div#comentarios').css('opacity', 1);
      }
   },
   set_pages: function(postid, page, autor) {
      var total = parseInt($('#ncomments').text());
      //
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/comentario-pages.php?page=' + page,
         data: 'postid=' + postid + '&autor=' + autor + '&total=' + total,
         success: function(h) {
            comentario.cache['p_' + page] = h;
            $('.paginadorCom').html(h);
            $('#com_gif').hide();
            $('div#comentarios').css('opacity', 1);
            SL2.stop();
         }
      });
   },
   // NUEVO COMENTARIO
   nuevo: function(mostrar_resp, comentarionum) {
      // EVITAR FLOOD
      $('#btnsComment').attr({
         'disabled': 'disabled'
      });
      //
      var textarea = $('#body_comm');
      var text = textarea.bbcode();
      // VACIO o DEFAULT
      if (text == '' || text == textarea.attr('title')) {
         textarea.focus();
         $('#btnsComment').removeAttr('disabled');
         return;
      } else if (text.length > 1500) {
         alert("Tu comentario no puede ser mayor a 1500 caracteres.");
         textarea.focus();
         $('#btnsComment').removeAttr('disabled');
         return;
      }
      // IMAGEN
      $('.miComentario #gif_cargando').show();
      var auser = $('#auser_post').val();
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/comentario-agregar.php',
         data: 'comentario=' + encodeURIComponent(text) + '&postid=' + gget('postid') + '&mostrar_resp=' + mostrar_resp + '&auser=' + auser,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  $('.miComentario .error').html(h.substring(3)).show('slow');
                  $('#btnsComment').removeAttr('disabled');
                  break;
               case '1': //OK
                  $("#nuevos").slideUp(1);
                  $('#preview').remove();
                  $('#nuevos').html(h.substring(3)).slideDown('slow', function() {
                     $('#no-comments').hide('slow');
                     $('.miComentario').html('<div class="alert alert-success text-center">Tu comentario fue agregado correctamente :)</div>');
                  });
                  // SUMAMOS
                  var ncomments = parseInt($('#ncomments').text());
                  $('#ncomments').text(ncomments + 1);
                  break;
            }
            SL2.stop();
            //
            $('.miComentario #gif_cargando').hide();
            mydialog.close();
         }
      });
   },
   // VISTA PREVIA DEL COMENTARIO
   preview: function(id, type) {
      var textarea = (type == 'new') ? $('#' + id) : $('#edit-comment-' + id);
      var text = (type == 'new') ? textarea.bbcode() : textarea.val();
      var btn_text = (type == 'new') ? 'Enviar comentario' : 'Guardar';
      var btn_fn = (type == 'new') ? "comentario.nuevo('true')" : 'comentario.editar(' + id + ', \'send\')';
      if (text == '' || text == textarea.attr('title')) {
         textarea.focus();
         return;
      } else if (text.length > 1500) {
         alert("Tu comentario no puede ser mayor a 1500 caracteres.");
         textarea.focus();
         return;
      }
      var auser = $('#auser_post').val();
      $('.miComentario #gif_cargando').show();
      //
      mydialog.class_aux = 'preview';
      mydialog.show(true);
      mydialog.title('...');
      mydialog.body('Cargando vista previa....<div class="loading loading-lg success"></div>');
      mydialog.center();
      //
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/comentario-preview.php?type=' + type,
         data: 'comentario=' + encodeURIComponent(text) + '&auser=' + auser,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  if (type == 'new') $('.miComentario .error').html(h.substring(3)).show('slow');
                  else {
                     $('#edit-error-' + id).css('color', 'red').html(h.substring(3));
                     mydialog.close();
                  }
                  $('.miComentario #gif_cargando').hide();
                  break;
               case '1': //OK
                  //
                  mydialog.body(h.substring(3));
                  mydialog.buttons(true, true, btn_text, btn_fn, true, true, true, 'Cancelar', 'close', true, false);
                  mydialog.center();
                  $('.miComentario #gif_cargando').hide();
                  $('.miComentario .error').html('');
                  break;
            }
            SL2.stop();
            mydialog.center();
         }
      });
   },
   // VOTAR COMENTARIO
   votar: function(cid, voto) {
      var voto_tag = $('#votos_total_' + cid)
      var total_votos = parseInt(voto_tag.text());
      total_votos = (isNaN(total_votos)) ? 0 : total_votos;
      // FIX
      voto = (voto == 1) ? 1 : -1;
      //
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/comentario-votar.php',
         data: 'voto=' + voto + '&cid=' + cid + '&postid=' + gget('postid'),
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert("Error al votar", h.substring(3));
                  break;
               case '1': //OK
                  total_votos = total_votos + voto;
                  if (total_votos > 0) total_votos = '+' + total_votos; // PONEMOS EL SIGNO + POR ESTETICA :P
                  var klass = (total_votos < 0) ? 'negativo' : 'positivo'; // CLASS
                  // MOSTRAMOS SI NO ES VISIBLE Y AGREGAMOS LA NUEVA CLASS
                  $('#ul_cmt_' + cid + ' > .numbersvotes').show();
                  voto_tag.text(total_votos).removeClass('positivo, negativo').addClass(klass);
                  // ESCONDEMOS LAS MANITAS xd
                  $('#ul_cmt_' + cid).find('.icon-thumb-up, .icon-thumb-down').hide();
                  break;
            }
            SL2.stop();
         }
      });
   },
   // CITAR
   citar: function(id, nick) {
      var textarea = $('#body_comm');
      textarea.focus();
      textarea.val(((textarea.val() != '') ? textarea.val() + '\n' : '') + '[quote=' + nick + ']' + htmlspecialchars_decode($('#citar_comm_' + id).html(), 'ENT_NOQUOTES') + '[/quote]\n');
   },
   // EDITAR
   editar: function(id, step) {
      switch (step) {
         case 'show':
            var bbcode = htmlspecialchars_decode($('#citar_comm_' + id).html(), 'ENT_NOQUOTES');
            var html = '<textarea id="edit-comment-' + id + '" class="textarea-edit form-input" placeholder="Escribir un comentario..." onfocus="onfocus_input(this)" onblur="onblur_input(this)">' + bbcode + '</textarea><br/><input type="button" class="btn btn-success btnEdit" onclick="comentario.preview(\'' + id + '\', \'edit\')" value="Continuar &raquo;"/> <strong id="edit-error-' + id + '"></strong>';
            $('#comment-body-' + id).html(html);
            $('#edit-comment-' + id).css('max-height', '300px');
            break;
         case 'send':
            var cid = $('#edit-cid-' + id).val()
            var comment = $('#edit-comment-' + id).val();
            SL2.start();
            $.ajax({
               type: 'POST',
               url: global_data.url + '/comentario-editar.php',
               data: 'comentario=' + encodeURIComponent(comment) + '&cid=' + id,
               success: function(h) {
                  switch (h.charAt(0)) {
                     case '0': //Error
                        $('#edit-error-' + id).css('color', 'red').html(h.substring(3));
                        break;
                     case '1': //OK
                        $('#comment-body-' + id).html($('#new-com-html').html());
                        var bbcode = htmlspecialchars_decode($('#new-com-bbcode').html(), 'ENT_NOQUOTES');
                        $('#citar_comm_' + id).html(bbcode)
                        break;
                  }
                  SL2.stop();
                  //
                  mydialog.close();
               }
            });
            break;
      }
   }
}
$(document).ready(function() {
   $('.tab-item').on('click', function(e) {
      $('.tab-item.active').removeClass('active');
      $(this).addClass('active');
   });
   // Obtenemos enlace para cambiarlo a TEXTO
   $('#downlink a').each(function() {
      // Obtenemos el elemento a
      var link = $(this);
      // Reemplazamos por este contenido
      link.html(`<img src="https://plus.google.com/_/favicon?domain=${link[0].origin}" class="icon" alt="${link[0].hostname}" /> <b>${link[0].hostname}</b>`).addClass('btn btn-primary btn-icon');
      // Borramos la clase
      $("#downlink").removeClass('load');
   });
});
var postsee = {
   cambiar: function(variable) {
      $.ajax({
         type: 'POST',
         url: global_data.url + '/posts-moresee.php',
         data: 'type=' + variable,
         success: function(response) {
            $('#moresee').html(response);
            SL2.stop();
         }
      });
   }
}
/* BBCode */
function spoiler(obj) {
   $(obj).toggleClass('show').parent().next().slideToggle();
}
//COMPARTIR EN REDES SOCIALES BY TO-UP.NET
function RedSocial(url) {
   window.open(url, 'nuevo', 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=700, height=400, left=300, top=150');
}