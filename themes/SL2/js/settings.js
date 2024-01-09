var guardar = {
   seo: function() {
      i = encodeURIComponent($('input[name=images]').val()),
      a = $('input[name=appfb]').val(),
      t = encodeURIComponent($('input[name=twuser]').val()),
      c = $('input[name=color]').val(),
      d = encodeURIComponent($('textarea[name=description]').val()),
      k = encodeURIComponent($('textarea[name=keys]').val()),
      params = `description=${d}&images=${i}&keys=${k}&color=${c}&app_fb=${a}&tw_page=${t}`;
      $.post(global_data.url + '/live-seo.php', params, function(h){
         mydialog.alert((h.charAt(0) == '0' ? 'Opps!' : 'Hecho'), h.substring(3), false);
         mydialog.buttons(true, true, 'Recargar sitio', "reloader()", true, false, true, 'Cancelar', 'close', true, false);
         mydialog.center();
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