var borradores = {
	eliminar: function(id, dialog){
		mydialog.close();
		if(dialog){
			mydialog.show();
			mydialog.title('Eliminar Borrador');
			mydialog.body('&iquest;Seguro que deseas eliminar este borrador?');
			mydialog.buttons(true, true, 'SI', 'borradores.eliminar(' + id + ', false)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
		}else{
		  $('#loading').fadeIn(250);
			$.ajax({
				type: 'POST',
				url: global_data.url + '/borradores-eliminar.php',
				data: 'borrador_id=' + id,
				success: function(h){
					switch(h.charAt(0)){
						case '0': //Error
						break;
						case '1':
						break;
					}
               $('#loading').fadeOut(350);
				},
				error: function(){	
					mydialog.alert('Error', 'Hubo un error al intentar procesar lo solicitado');
               $('#loading').fadeOut(350);
				}
			});
		}
	}
}

