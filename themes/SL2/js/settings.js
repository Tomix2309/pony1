var guardar = {
   seo: function() {
      const params = $('form[name=confSeo]').serialize();
      $.post(global_data.url + '/live-seo.php', params, response => {
         console.log(response)
         const title = response.charAt(0) == '0' ? 'Opps!' : 'Hecho';
         const reload = response.charAt(0) == '0' ? false : true;
         mydialog.alert(title, response.substring(3), reload);
         $('#loading').fadeOut(350);
      });
   },
   header: function() {
      const params = $('form[name=confHeader]').serialize();
      $.post(global_data.url + '/live-header.php', params, function(h) {
         console.log(h)
         mydialog.alert((h.charAt(0) == '0' ? 'Opps!' : 'Hecho'), h.substring(3), false);
         mydialog.buttons(true, true, 'Recargar sitio', "reloader()", true, false, true, 'Cancelar', 'close', true, false);
         mydialog.center();
         $('#loading').fadeOut(350);
      });
   }
}
function reloader() {
   return location.href = window.location.pathname;
}
function acortar() {
   text = $('input[name=urlacortar]').val();
   $.ajax({
      type: 'POST',
      url: global_data.url + '/generador-acortar.php',
      data: 'url_acortar=' + text,
      success: function(respond) {
         $('#result').html('<p class="p-3 h4">Link acortado: ' + respond + '</p>');
      }
   })
}

$(document).ready(() => {
   const titulo = $('form[name=confSeo] #titulo');
   const descripcion = $('form[name=confSeo] #descripcion');
   const portada = $('form[name=confSeo] #portada');
   titulo.on('keyup', () => $('.result .title').html(titulo.val()))
   descripcion.on('keyup', () => $('.result .descripcion').html(descripcion.val()))
   portada.on('keyup', () => $('.result .image').attr({ src: portada.val() }))
})