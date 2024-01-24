// FEED SUPPORT
$.getJSON(global_data.url + "/feed-support.php", response => {
	//console.log(response)
	$('#ulitmas_noticias .emptyData').html('Obteniendo información...');
	if(Array.isArray(response)) {
		$('#ulitmas_noticias').html('');
		response.map( data => {
			const { link, title, info, version } = data;
			var html = `<li onclick="javascript:window.open('${link}', '_blank')" class="list-group-item d-flex justify-content-between align-items-start" style="cursor: pointer;">
		    	<div class="ms-2 me-auto">
		     		<div class="fw-bold">${title} <span class="fw-normal small badge bg-primary">${version}</span></div>
		      	<em>${info}</em>
		    	</div>
		  	</li>`;
			$('#ulitmas_noticias').addClass('list-group list-group-flush list-group-numbered').removeClass('list-unstyled').append(html);
		})
	} else $('#ulitmas_noticias').html(`<div class="emptyData">${response}</div>`)
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

changeBranch = (branch = 'main') => {
	$.post(global_data.url + '/github-api.php', { branch }, response => {
		console.log(response)
		var cookiename = "LastCommitSha";
		var expires = { expires: 7 }
		//
		$('#lastCommit').html('');
		// Reemplazamos \n por saltos de línea con <br>
		content = response.commit.message.replace(/\n/g, '<br>');
		// Si la pantalla es menor a 1120px solo tendrá 7 caracteres
		SHA = (window.width < 1120) ? response.sha.substring(0, 7) : response.sha;
		let hace = $.timeago(response.commit.author.date)
		//
		var added = 0;
		var modified = 0;
		var deleted = 0;
		response.files.map( file => {
			if(file.status === 'added') added += 1;
			if(file.status === 'modified') modified += 1;
			if(file.status === 'deleted') deleted += 1;
		})
		// Creamos la plantilla para mostrar la infomación del mismo
		var html = `<div class="data-github">${content}<hr style="margin-top:.8rem;"><div class="row row-cols-3" style="font-size:1rem;">
			<small>Agregados <strong>${added}</strong></small>
			<small>Modificados <strong>${modified}</strong></small>
			<small>Eliminados <strong>${deleted}</strong></small>
		</div></div>`;

		$('.panel-info.last-commit .card-footer').html(`<span>Sha: <a href="${response.html_url}" class="text-decoration-none text-primary" rel="noreferrer" target="_blank">${SHA}</a></span><span>${hace}</span>`);

		// La añadimos al HTML
		let transform = joypixels.toImage(html);
		$('#lastCommit').append(transform);
	}, 'json')
}
// Autoejecutamos
changeBranch();