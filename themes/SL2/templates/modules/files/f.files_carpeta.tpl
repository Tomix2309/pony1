{if $tsCarpeta.archivos}
	<h4>{$tsCarpeta.nombre}</h4>

	<table class="table">
	  	<thead>
	    	<tr>
	      	<th scope="col">ID</th>
	      	<th scope="col">Archivo</th>
	      	<th scope="col">Descargas</th>
	      	<th scope="col">Comentarios</th>
	      	<th scope="col">Activo</th>
	      	<th scope="col">Acciones</th>
	    	</tr>
	  	</thead>
	  	<tbody>
	  		{foreach $tsCarpeta.archivos key=i item=arc}
	   	<tr>
	      	<th scope="row">{$arc.arc_id}</th>
	      	<td>{$arc.arc_name}.{$arc.arc_ext} <small class="d-block">{$arc.arc_weight}</small></td>
	      	<td>{$arc.arc_downloads}</td>
	      	<td>{$arc.arc_comments}</td>
	      	<td>{if $arc.arc_status == 1}Activo{else}Inactivo{/if}</td>
	      	<td>
	      		<a href="#" class="btn btn-sm btn-primary">Eliminar</a>
	      		<a href="#" class="btn btn-sm btn-primary">Editar</a>
	      		<a href="#" class="btn btn-sm btn-primary">Mover</a>
	      	</td>
	    	</tr>
			{/foreach}
	  	</tbody>
	</table>
	<nav aria-label="Paginacion de archivos">
  				<ul class="pagination">
  					{$tsCarpeta.pages}
  				</ul>
  			</nav>
{else}

	<div class="my-4 bg-dark-subtle p-5 rounded shadow">
		<h3>{$tsCarpeta.titulo}</h3>
		<p>{$tsCarpeta.mensaje}</p>
	</div>
	
{/if}
