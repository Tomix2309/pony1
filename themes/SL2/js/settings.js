var guardar = {
   seo: function() {
      const params = $('form[name=confSeo]').serialize();
      $.post(global_data.url + '/settings-seo.php', params, response => {
         const title = response.charAt(0) == '0' ? 'Opps!' : 'Hecho';
         const reload = response.charAt(0) == '0' ? false : true;
         mydialog.alert(title, response.substring(3), reload);
         SL2.stop();
      });
   },
   header: function() {
      const params = $('form[name=confHeader]').serialize();
      $.post(global_data.url + '/settings-header.php', params, function(h) {
         console.log(h)
         mydialog.alert((h.charAt(0) == '0' ? 'Opps!' : 'Hecho'), h.substring(3), false);
         mydialog.buttons(true, true, 'Recargar sitio', "reloader()", true, false, true, 'Cancelar', 'close', true, false);
         mydialog.center();
         SL2.stop();
      });
   }
}
function reloader() {
   return location.href = window.location.pathname;
}

$(document).ready(() => {
   const titulo = $('form[name=confSeo] #titulo');
   const descripcion = $('form[name=confSeo] #descripcion');
   const portada = $('form[name=confSeo] #portada');
   titulo.on('keyup', () => $('.result .title').html(titulo.val()))
   descripcion.on('keyup', () => $('.result .descripcion').html(descripcion.val()))
   portada.on('keyup', () => $('.result .image').attr({ src: portada.val() }))
});