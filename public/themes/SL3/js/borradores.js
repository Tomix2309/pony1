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
		  SL2.start();
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
               SL2.stop();
				},
				error: function(){	
					mydialog.alert('Error', 'Hubo un error al intentar procesar lo solicitado');
               SL2.stop();
				}
			});
		}
	}
}

