/**
 * Funciones para subir el archivo
*/


function redireccionar() {
   location.href = global_data.url + '/files/';
}
$(document).ready(function(){
	const btn = $('#New_file')

	btn.on('change', (e) => {
		// Obtén la información del archivo seleccionado
      const archivoInput = document.getElementById('New_file');
      const archivo = archivoInput.files[0];

      if (archivo) {
         const formData = new FormData();
         formData.append('archivo', archivo);

         fetch(global_data.url + '/files-info.php', {
             method: 'POST',
             body: formData
         })
         .then(response => response.json())
         .then(data => {
          	const { ext, format, icon, name, weight } = data;
          	const html = `<div class="info-file mb-3">
          		<div class="info-file-img">
          			<img src="${global_data.img}images/files/${icon}.png">
          		</div>
          		<h3 class="fw-bold mb-1">${name} [${ext}]</h3>
          		<span class="d-block">Formato: <strong>${format}</strong></span>
          		<span class="d-block">Peso: <strong>${weight}</strong></span>
          	</div>`
          	$('.result_text').html(html).fadeIn(100);
          	$('#Select_file > a.list_text').fadeOut(100);
              // Aquí puedes manejar la respuesta del servidor
         })
         .catch(error => console.error('Error:', error));
      } else console.log('Seleccione un archivo.');
	});

	var options = {
		beforeSend: function() {
			$("#progress").fadeIn(250);
			$("#bar").css('width', '0%');
			$("#message").html("").hide();
			$("#percent").html("0%");
		},
		uploadProgress: function(event, position, total, percentComplete) {
			$("#bar").css('width', percentComplete+'%');
			$("#percent").html(percentComplete+'%');    
		},
		success: function() {
			$("#bar").css('width', '100%');
			$("#percent").html('100%');
		},
		complete: function(response) {
			var result = response.responseText;
			var msj = $("#message");
			msj.show();
			switch(result.charAt(0)){
				case '0': //Error
					mydialog.procesando_fin();
					$('#start_upload').slideUp(200);
					mydialog.alert('Error', result.substring(3));
				break;
				case '1':
					mydialog.show(true);
					mydialog.title('Correcto');
					mydialog.body(result.substring(3));
					mydialog.buttons(true, true, 'Cerrar', 'redireccionar()', true, true);
					mydialog.center();
				break;
			}
		}     
	}; 
   $("#New_upload").ajaxForm(options);	
});