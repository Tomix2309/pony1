/**
 * Función actualizar comentarios
*/
function actualizar_comentarios(cat, nov) {
   SL2.start();
   $('#ult_comm, #ult_comm > ol').slideUp(150);
   $.post(global_data.url + '/posts-last-comentarios.php', { cat, nov }, h => {
      $('#ult_comm').html(h);
      $('#ult_comm > ol').hide();
      $('#ult_comm, #ult_comm > ol:first').slideDown(1500, 'easeInOutElastic');
      SL2.stop();
   }).fail(() => {
      $('#ult_comm, #ult_comm > ol:first').slideDown({duration: 1000,easing: 'easeOutBounce'});
      SL2.stop();
   });
}
