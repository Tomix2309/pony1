/*
    PERFIL
*/
var perfil = {
   cache: {},
   load_tab: function(type, obj) {
      // CSS
      $('#tabs_menu > li a').removeClass('active');
      $(obj).parent().addClass('active');
      //
      $('#perfil_content > div').fadeOut();
      $('#perfil_load').fadeIn();
      // CARGAMOS
      perfil.cargar(type);
   },
   // CARGAR CONTENIDO
   cargar: function(type) {
      //
      var status = $('#perfil_' + type).attr('status');
      if (status == 'activo') {
         // LOADER/ STATUS
         $('#perfil_load').hide();
         $('#perfil_' + type).fadeIn();
         return true;
      }
      //
      $('#loading').slideDown(250);
      $.ajax({
         type: 'POST',
         url: global_data.url + '/perfil-' + type + '.php',
         data: 'pid=' + $('#info').attr('pid'),
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error', h.substring(3));
                  break;
               case '1': //OK
                  if (typeof perfil.cache[type] == 'undefined') {
                     $('#perfil_content').append(h.substring(3));
                     $('#perfil_' + type).fadeIn();
                     perfil.cache[type] = true;
                  }
                  break;
            }
            // LOADER/ STATUS
            $('#perfil_load').hide();
            $('#loading').slideUp(350);
         }
      });
   },
   // CARGAR PAGINAS DE LOS SEGUIDORES!
   follows: function(type, page) {
      $.ajax({
         type: 'POST',
         url: global_data.url + '/perfil-' + type + '.php?hide=true&page=' + page,
         data: 'pid=' + $('#info').attr('pid'),
         success: function(h) {
            $('#perfil_' + type).html(h.substring(3));
         }
      });
   }
}
/** ACTIVIDAD **/
var actividad = {
   total: 25,
   show: 25,
   cargar: function(id, ac_do, ac_type) {
      // ELIMINAR
      $('#last-activity-view-more').remove();
      if (ac_do == 'filtrar') actividad.total = 0;
      // ENVIAMOS
      $.ajax({
         type: 'POST',
         url: global_data.url + '/perfil-actividad.php',
         data: 'pid=' + $('#info').attr('pid') + '&ac_type=' + ac_type + '&do=' + ac_do + '&start=' + actividad.total,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error', h.substring(3));
                  break;
               case '1': //OK
                  if (ac_do == 'more') $('#last-activity-container').append(h.substring(3));
                  else $('#last-activity-container').html(h.substring(3));
                  // TOTALES
                  var total_pubs = $('#total_acts').attr('val');
                  actividad.total = actividad.total + parseInt(total_pubs);
                  $('#total_acts').remove();
                  break;
            }
         }
      });
   },
   borrar: function(id, obj) {
      // ENVIAMOS
      $.ajax({
         type: 'POST',
         url: global_data.url + '/perfil-actividad.php',
         data: 'pid=' + $('#info').attr('pid') + '&acid=' + id + '&do=borrar',
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error', h.substring(3));
                  break;
               case '1': //OK
                  $(obj).parent().parent().parent().remove();
                  break;
            }
         }
      });
   }
}
/** MURO **/
var muro = {
   maxWidth: 463, // WIDTH PARA LAS FOTOS Y VIDEOS
   stream: {
      total: 0, // TOTAL DE PUBLICACIONES CARGADAS
      show: 10, // CUANTOS SE MUESTRAN POR CADA CARGA
      type: 'status', // TIPO D PUBLICACION ACTUAL
      status: 0, // PARA EVITAR CLICKS INESESARIOS
      adjunto: '', // SE HA CARGADO UN ARCHIVO ADJUNTO?
      // CARGAR EL TIPO DE PUBLICACION :
      load: function(aid, obj) {
         // ACTUAL
         muro.stream.type = aid;
         const txtwall = $("textarea#wall");
         //
         let atxt = 'Haz un comentario sobre est' + (aid == 'foto' ? 'a' : 'e') + ' ' + aid + '...';
         if(aid == 'status') {
            atxt = (txtwall.data('info-uid') == txtwall.data('uid')) ? '¿Qué estás pensando?' : 'Escribe algo....';
            $('#adjuntar').removeClass('mb-2').html('')
         } else {
            const adjuntar = $('#adjuntar').addClass('mb-2');
            const tipos = {
               foto: global_data.url + '/images/ejemplo.jpg',
               enlace: global_data.url + '/blog/ejemplo.html',
               video: 'https://www.youtube.com/watch?v=f_30BAGNqqA'
            }
            const html = `<input type="text" class="form-control" name="i${aid}" placeholder="${tipos[aid]}" aria-label="Adjuntar archivo" aria-describedby="button-addon2"/>
            <button type="button" class="btn btn-outline-secondary adj" onclick="muro.stream.adjuntar(); return false;">Adjuntar</button>`;
            adjuntar.html(html)
         }
         txtwall.attr({ placeholder: atxt })
         return false;
      },
      // ADJUNTAR ARCHIVO EXTERNO : FOTO, ENLACE, VIDEO DE YOUTBE
      adjuntar: function() {
         // SI ESTA OCUPADO NO HACEMOS NADA
         if (muro.stream.status == 1) return false;
         else muro.stream.status = 1;
         // LOADER
         muro.stream.loader(true);
         // FUNCION
         var inpt = $('input[name=i' + muro.stream.type + ']');
         inpt.attr('disabled', 'true');
         const loading = `<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Adjuntando...</span>`
         $('.btn.adj').html(loading)
         var valid = muro.stream.validar(inpt);
         if (valid == true) {
            // ADJUNTAMOS...
            muro.stream.ajaxCheck(inpt.val(), inpt);
         } else {
            mydialog.alert('Error al publicar', valid);
            // LOADER / DISABLED / STATUS
            muro.stream.loader(false);
            inpt.attr('disabled', '');
            muro.stream.status = 0;
         }
      },
      // VERIFICAR ARCHIVO
      ajaxCheck: function(url, inpt) {
         SL2.start();
         url = encodeURIComponent(url);
         $.post(`${global_data.url}/muro-stream.php?do=check&type=${muro.stream.type}`, { url }, h => {
            console.log(h)
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error al publicar', h.substring(3));
                  inpt.attr('disabled', '');
               break;
               case '1': //OK
                  muro.stream.adjunto = inpt.val();
                  $('#preview').html(h.substring(3));
                  $('#adjuntar').html('')
               break;
            }
            SL2.stop();
         }).done(() => {
            // LOADER/ STATUS
            muro.stream.loader(false);
            muro.stream.status = 0;
            SL2.stop();
         })
      },
      // VALIDAR LAS URL DE LOS ARCHIVOS ADJUNTOS
      validar: function(inpt) {
         var val = inpt.val();
         var regex = /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,3}|info|mobi|aero|asia|name)(:\d{2,5})?(\/)?((\/).+)?$/i;
         //
         if (val == '' || val == inpt.attr('title') || regex.test(val) == false) return 'Debes ingresar una direcci&oacute;n URL v&aacute;lida.';
         else {
            switch (muro.stream.type) {
               case 'foto':
                  inpt.val(val.replace(' ', ''));
                  var ext = inpt.val().substr(-3);
                  if (ext != 'gif' && ext != 'png' && ext != 'jpg') return 'S&oacute;lo se permiten im&aacute;genes .gif, .png y .jpg';
                  break;
               case 'video':
                  if(isYoutube(val) === false) return 'Al parecer la url del video no es v&aacute;lida. Recuerda que solo puedes compartir videos de YouTube.';
                  break;
            }
            //
            return true;
         }
      },
      // COMPARTIR
      compartir: function() {
         // SI ESTA OCUPADO NO HACEMOS NADA
         if (muro.stream.status == 1) return false;
         else muro.stream.status = 1;
         // LOADER
         muro.stream.loader(true);
         // 
         var error_length = 'Las publicaciones de estado y/o comentarios deben ser inferiores a 420 caracteres. Ya has ingresado ';
         // ARCHIVOS ADJUNTOS
         if (muro.stream.type != 'status') {
            if (muro.stream.adjunto != '') {
               var val = $('#wall').val();
               // VALIDAR
               if (val.length > 420) {
                  mydialog.alert('Error al publicar', error_length + val.length + ' caracteres.');
                  // LOADER/ STATUS
                  muro.stream.loader(false);
                  muro.stream.status = 0;
               }
               // ENVIAMOS PUBLICACION
               else {
                  val = (val == $('#wall').attr('title')) ? '' : val;
                  muro.stream.ajaxPost(val);
               }
            } else {
               mydialog.alert('Error al publicar', 'Ingresa la <b>URL</b> en el campo de texto y a continuaci&oacute;n da clic en <b>Adjuntar</b>.');
               // LOADER/ STATUS
               muro.stream.loader(false);
               muro.stream.status = 0;
            }
            // PUBLICACION SIMPLE
         } else if (muro.stream.type == 'status') {
            var status = $('#wall');
            var val = status.val();
            var error = false;
            // VALIDAR
            if (val == '' || val == status.attr('title')) {
               status.blur();
               error = true;
               // LOADER/ STATUS
               muro.stream.loader(false);
               muro.stream.status = 0;
               return false;
            } else if (val.length > 420) error = error_length + val.length + ' caracteres.';
            // ENVIAR PUBLICACION
            if (error == false) {
               muro.stream.ajaxPost(val);
            } else {
               mydialog.alert('Error al publicar', error);
               // LOADER/ STATUS
               muro.stream.loader(false);
               muro.stream.status = 0;
            }
         }
      },
      // POSTEAR EN EL MURO
      ajaxPost: function(data) {
         $('#loading').slideDown(250);
         $('#loaderStatus').addClass('d-flex').removeClass('d-none');
         $.ajax({
            type: 'POST',
            url: global_data.url + '/muro-stream.php?do=post&type=' + muro.stream.type,
            data: 'adj=' + muro.stream.adjunto + '&data=' + encodeURIComponent(data) + '&pid=' + $('#info').attr('pid'),
            success: function(h) {
               switch (h.charAt(0)) {
                  case '0': //Error
                     mydialog.alert('Error al publicar', h.substring(3));
                     $('#loaderStatus').addClass('d-flex').removeClass('d-none');
                  break;
                  case '1': //OK
                     // ESCONDEMOS SI ES EL PRIMER COMENTARIO
                     if ($('#wall-content .emptyData')) $('#wall-content .emptyData').hide();
                     //
                     $('#wall-content').prepend($(h.substring(3)).fadeIn('slow'));
                     $('#wall').val('').focus();
                     $('#preview').html('');
                     muro.stream.load('status', $('#stMain'));
                     $('#loaderStatus').addClass('d-flex').removeClass('d-none');
                  break;
               }
               $('#loading').slideUp(350);
            },
            complete: function() {
               // LOADER/ STATUS
               muro.stream.loader(false);
               muro.stream.status = 0;
               SL2.stop();
               $('#loaderStatus').removeClass('d-flex').addClass('d-none');;
            }
         });
      },
      loadMore: function(type) {
         // SI ESTA OCUPADO NO HACEMOS NADA
         if (muro.stream.status == 1) return false;
         else muro.stream.status = 1;
         // LOADER
         $('.more-pubs a').hide();
         $('.more-pubs span').css('display', 'block');
         // CARGAMOS
         SL2.start();
         $.ajax({
            type: 'POST',
            url: global_data.url + '/muro-stream.php?do=more&type=' + type,
            data: 'pid=' + $('#info').attr('pid') + '&start=' + muro.stream.total,
            success: function(h) {
               switch (h.charAt(0)) {
                  case '0': //Error
                     mydialog.alert('Error al cargar', h.substring(3));
                     break;
                  case '1': //OK
                     // CARGAMOS AL DOM
                     $('#' + type + '-content').append(h.substring(3));
                     // VALIDAMOS
                     var total_pubs = $('#total_pubs').attr('val');
                     total_pubs = parseInt(total_pubs);
                     // 
                     var msg = (type == 'news' && total_pubs < 0) ? 'Solo puedes ver las &uacute;ltimas 100 publicaciones.' : 'No hay m&aacute;s mensajes para mostrar.';
                     if (total_pubs == 0 || total_pubs < muro.stream.show) $('.more-pubs').html(msg).css('padding', '10px');
                     else muro.stream.total = muro.stream.total + parseInt(total_pubs);
                     // REMOVER
                     $('#total_pubs').remove();
                     break;
               }
               SL2.stop();
            },
            complete: function() {
               $('.more-pubs a').show();
               $('.more-pubs span').hide();
               muro.stream.status = 0;
               SL2.stop();
            }
         });
      },
      // LOADER
      loader: function(active) {
         if (active == true) $('.streamLoader').show();
         else if (active == false) $('.streamLoader').hide();
      }
   },
   // LIKE
   like_this: function(id, type, obj) {
      muro.stream.status = 1;
      // MANDAMOS
      $('#loading').slideDown(250);
      $.ajax({
         type: 'POST',
         url: global_data.url + '/muro-likes.php',
         dataType: 'json',
         data: 'id=' + id + '&type=' + type,
         success: function(h) {
            if (h['status'] == 'ok') {
               // I LIKE / NO
               $(obj).text(h['link']);
               //
               if (type == 'pub') {
                  $('#lk_' + id).html(h['text']);
                  if (h['text'] != '') {
                     $('#lk_' + id).parent().parent().show();
                     $('#cb_' + id).show();
                  } else $('#lk_' + id).parent().parent().hide();
               } else {
                  $('#lk_cm_' + id).text(h['text']);
                  if (h['text'] == '') $('#lk_cm_' + id).parent().hide();
                  else $('#lk_cm_' + id).parent().show();
               }
            } else mydialog.alert('Error:', h['text'].substring(3));
            $('#loading').slideUp(350);
         },
         complete: function() {
            // STATUS
            muro.stream.status = 0;
         }
      });
   },
   show_likes: function(id, type) {
      muro.stream.status = 1;
      // MANDAMOS
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/muro-likes.php?do=show',
         dataType: 'json',
         data: 'id=' + id + '&type=' + type,
         success: function(h) {
            switch (h.status) {
               case 0: //Error
                  mydialog.alert('Error', h['data']);
                  break;
               case 1: //OK
                  var html = '<ul id="show_likes">';
                  for (var i = 0; i < h.data.length; i++) {
                     html += '<li>'
                     html += '<a href="' + global_data.url + '/perfil/' + h.data[i].user_name + '"><img src="' + global_data.url + '/files/avatar/' + h.data[i].user_id + '.webp" /></a>'
                     html += '<div class="name"><a href="' + global_data.url + '/perfil/' + h.data[i].user_name + '">' + h.data[i].user_name + '</a></div>'
                     html += '</li>';
                  }
                  html += '</ul>';
                  // MOSTRAMOS
                  mydialog.show(true);
                  mydialog.title('Personas a las que les gusta');
                  mydialog.body(html);
                  mydialog.buttons(true, true, 'Cerrar', 'close', true, true);
                  mydialog.center();
                  break;
            }
            SL2.stop();
         },
         complete: function() {
            // STATUS
            muro.stream.status = 0;
         }
      });
   },
   show_comment_box: function(id) {
      $('#cb_' + id).slideDown()
   },
   comentar: function(id) {
      var val = $('#cf_' + id).val();
      muro.stream.status = 1;
      if (val == '' || val == $('#cf_' + id).attr('title')) {
         $('#cf_' + id).focus();
         // LOADER/ STATUS
         muro.stream.loader(false);
         muro.stream.status = 0;
         return false;
      }
      //
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/muro-stream.php?do=repost',
         data: 'data=' + encodeURIComponent(val) + '&pid=' + id,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error:', h.substring(3));
                  break;
               case '1': //OK
                  $('#cl_' + id).append($(h.substring(3)).fadeIn('slow'));
                  $('#cf_' + id).val('');
                  break;
            }
            SL2.stop();
         },
         complete: function() {
            // STATUS
            muro.stream.status = 0;
            SL2.stop();
         }
      });
   },
   //
   more_comments: function(id, obj) {
      // LOADER / STATUS
      muro.stream.status = 1;
      $(obj).parent().find('img').show();
      //
      SL2.start();
      $.ajax({
         type: 'POST',
         url: global_data.url + '/muro-stream.php?do=more_comments',
         data: 'pid=' + id,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error:', h.substring(3));
                  break;
               case '1': //OK
                  $('#cl_' + id).html(h.substring(3));
                  break;
            }
            SL2.stop();
         },
         complete: function() {
            // STATUS
            muro.stream.status = 0;
            SL2.stop();
         }
      });
   },
   // MOSTRAR VIDEO DEL MURO
   load_atta: function(type, ID, obj) {
      switch (type) {
         case 'foto':
            var content = '<center><img src="' + ID + '" style="width:' + this.maxWidth + 'px;" /><center>'; //bzox
            break;
         case 'video':
            $('.uiVideo').css({
               'display': 'block',
               'height': '315px'
            });
            var content = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' + ID + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            break;
      }
      // CARGAMOS
      $(obj).parent().html(content);
   },
   // ELIMINAR PUBLICACION / COMENTARIO
   del_pub: function(id, type) {
      var txt_type = (type == 1) ? 'publicaci&oacute;n' : 'comentario';
      var txt_aux = (type == 1) ? 'esta ' : 'este ';
      //
      mydialog.mask_close = false;
      mydialog.show(true);
      mydialog.title('Eliminar ' + txt_type);
      mydialog.body('¿Seguro que quieres eliminar ' + txt_aux + txt_type);
      mydialog.buttons(true, true, 'Eliminar ' + txt_type, 'muro.eliminar(' + id + ', ' + type + ')', true, true, true, 'Cancelar', 'close', true, false);
      mydialog.center();
   },
   // ELIMINAR PUBLICACION / COMENTARIO
   eliminar: function(id, type) {
      // LOADER / STATUS
      muro.stream.status = 1;
      var snd_type = (type == 1) ? 'pub' : 'cmt';
      //
      $('#loading').slideDown(250);
      $.ajax({
         type: 'POST',
         url: global_data.url + '/muro-stream.php?do=delete',
         data: 'id=' + id + '&type=' + snd_type,
         success: function(h) {
            switch (h.charAt(0)) {
               case '0': //Error
                  mydialog.alert('Error:', h.substring(3));
                  break;
               case '1': //OK
                  mydialog.close();
                  $('#' + snd_type + '_' + id).hide().remove();
               break;
            }
            $('#loading').slideUp(450);
         },
         complete: function() {
            // STATUS
            muro.stream.status = 0;
            $('#loading').slideUp(350);
         }
      });
   }
   //
}
function dispositivo(type) {
   var disp = type;
   mydialog.show(true);
   mydialog.title('Dispositivo');
   mydialog.body(disp);
   mydialog.buttons(true, true, 'Cerrar', 'close', true, false);
   mydialog.center();
} 
/** READY **/
$(function() {
   // WALL
   $('#wall').focus(function() {
      $('.btnStatus').show();
   });
   // ENVIAR PUBLICACION
   $('textarea[name=add_wall_comment]').on("keypress", function(k) {
      if (k.which == 13) {
         var pub_id = $(this).attr('pid');
         muro.comentar(pub_id);
         return false;
      }
   });
   // ADJUNTAR
   $('.adj').on(() => aid = $(this).attr('aid'))
   //
   $('input[name=hack]').on("focus", function() {
      $(this).hide();
      $(this).parent().find('div.formulario').show();
      var pub_id = $(this).attr('pid');
      //
      $('#cf_' + pub_id).focus()
   });
});

const portada = {
   cambiar: () => {
      $('#cambiar-portada-text').html('Espere...');
      const pid = global_data.user_key;
      $.post(global_data.url + '/perfil-cambiar.php', { pid }, response => {
         $('#cambiar-portada-text').html('Cambiar portada');
         mydialog.show(true);
         mydialog.title('Cambiar portada!');
         mydialog.body(response);
         mydialog.buttons(true, true, 'Aplicar cambios...', 'portada.subir()',true, true, true, 'Cerrar', 'close', true, false);
         mydialog.center();
      })
   },
   subir: () => {
      const data = $('#changeCover').serialize();
      mydialog.procesando_inicio(2, 'Haciendo cambios, espere...');
      $.post(global_data.url + '/perfil-portada.php', data, response => {
         $('.portada-perfil').removeAttr('style')
         const { obj, msg } = response
         let newStyles = { backgroundImage: `url('${obj.url}')`, ...obj.css };
         if(msg.charAt(0) === '1') {
            $('.portada-perfil').css(newStyles);
            mydialog.alert('Bien!', msg.substring(3), false)
         } else mydialog.alert('Error!', msg.substring(3), false)
         mydialog.procesando_fin();
      }, 'json');
   }
}
// CARGAMOS EL ARCHIVO DE CUENTA PARA SUBIR AVATAR
$(document).ready(() => $.getScript(global_data.img + "/js/cuenta.js"))
