/**
 * Función actualizar comentarios
*/
function actualizar_comentarios(cat, nov) {
   $('#loading').fadeIn(250);
   $('#ult_comm, #ult_comm > ol').slideUp(150);
   $.ajax({
      type: 'GET',
      url: global_data.url + '/posts-last-comentarios.php',
      cache: false,
      data: 'cat=' + cat + '&nov=' + nov,
      success: function(h) {
         $('#ult_comm').html(h);
         $('#ult_comm > ol').hide();
         $('#ult_comm, #ult_comm > ol:first').slideDown(1500, 'easeInOutElastic');
         $('#loading').fadeOut(350);
      },
      error: function() {
         $('#ult_comm, #ult_comm > ol:first').slideDown({duration: 1000,easing: 'easeOutBounce'});
         $('#loading').fadeOut(350);
      }
   });
}
