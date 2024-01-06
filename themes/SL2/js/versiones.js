// FEED SUPPORT
$.getJSON(global_data.url + "/feed-support.php", response => {
	//console.log(response)
	$('#ulitmas_noticias').html('Obteniendo información...');
	if(Array.isArray(response)) {
		$('#ulitmas_noticias').html('');
		response.map( data => {
			const { link, title, info, version } = data;
			var html = `<a href="${link}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-dark py-2">
			 	<div class="me-auto">
			   	<div class="fw-bold">${title}</div>
			   	<span class="small text-secondary">${info}</span>
			 	</div>
    			<span class="badge text-white bg-primary rounded-pill">${version}</span>
			</a>`;
			$('#ulitmas_noticias').append(html);
		})
	} else $('#ulitmas_noticias').html(`<div class="phpostAlfa">${response}</div>`)
})

//
$.getJSON(global_data.url + "/feed-version.php?v=risus", response => {
	const { title, text, color } = response;
	// Clonamos
  	var clonar = $('.list-clone').first().clone();
  	// Añadimos color
  	clonar.addClass(color)
  	// Modificar los datos dentro del clon
  	clonar.find('.fw-bold').text(title);
  	clonar.find('.text-secondary').text(text);
  	// Agregar el clon a la lista
		if(typeof title === 'undefined') {
		clonar.addClass('list-group-item-danger')
		clonar.find('.fw-bold').text('No version');
  		clonar.find('.text-secondary').text(response);
	}
  	$('#ultima_version').append(clonar);
});