{if $tsUser->is_member}<div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 col-xx-9">{/if}
	<div class="row">
		<div class="col-12 col-sm-12 col-md-2 col-lg-3 col-xl-3 col-xx-3">
			{include "f.files_content_filter.tpl"}
		</div>
		<div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 col-xx-9">
			<div class="buscar-archivo mb-3">
				<form action="" name="file_search">
					<input type="search" name="file" placeholder="Que archivo buscas..." class="form-control">
				</form>
			</div>

			<div class="list-files py-3">
				{foreach $tsArchivos.files key=fid item=file}
					<div class="list-files-item mb-2 bg-light-subtle rounded" id="archivo-{$file.arc_id}">
						<span id="arc_code" style="display: none;">{$file.arc_code}</span>
						<div class="item-cover d-flex justify-content-center align-items-center flex-column">
							<img src="{$tsConfig.images}/files/{$file.arc_ico}.png" alt="{$file.arc_code}">
						</div>
						<div class="item-data p-1">
							<h4 class="fs-6">{if !empty($file.car_name)}<a href="{$tsConfig.url}/files/carpeta/{$file.car_seo}" class="fw-bold text-dark-emphasis" rel="internal">{$file.car_name|ucfirst}</a>\{/if}<a href="{$tsConfig.url}/files/ver/{$file.arc_code}" rel="internal" class="text-dark-emphasis">{$file.arc_name|ucfirst}.{$file.arc_ext|lower}</a></h4>
							<small class="d-block text-muted">
								Por: <a href="{$tsConfig.url}/perfil/{$file.user_name}" rel="internal" class="text-dark-emphasis fw-bold">{$file.user_name}</a> &bull;
								<span>{$file.arc_date|hace}</span> &bull;
								Descargas: <span>{$file.arc_downloads}</span>
							</small>
						</div>
						<div class="item-action text-end position-relative mt-2">

							<span role="button" onclick="Files.archivo.opciones({$file.arc_id}, false);" class="btn btn-sm text-dark-emphasis"><i data-feather="more-vertical"></i></span>
							<div class="item-options bg-light-subtle shadow position-absolute closed" data-id="{$file.arc_id}" id="option{$file.arc_id}">
								<a role="button" class="text-dark-emphasis" href="{$tsConfig.url}/files/descargar/{$file.arc_code}"><i data-feather="download"></i> Descargar</a>
								<span role="button" onclick="Files.archivo.informacion({$file.arc_id});"><i data-feather="info"></i> Información</span>
								{if $tsUser->uid == $file.user_id}
									<span role="button" onclick="Files.archivo.editar({$file.arc_id});"><i data-feather="edit-2"></i> Editar</span>
									<span role="button" onclick="Files.archivo.eliminar({$file.arc_id});"><i data-feather="trash-2"></i> Borrar</span>
									<span role="button" onclick="Files.archivo.mover({$file.arc_id});"><i data-feather="move"></i> Mover</span>
								{/if}
							</div>
						</div>
					</div>
				{/foreach}
			</div>
			<nav aria-label="Paginacion de archivos">
  				<ul class="pagination">
  					{$tsArchivos.pages}
  				</ul>
  			</nav>
		</div>
	</div>
{if $tsUser->is_member}</div>{/if}