<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<div class="nofio">
	{if $tsLastFotos.data}
	<div class="row" data-masonry='{"itemSelector": ".card-item" }'>
	{foreach from=$tsLastFotos.data item=f}
		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 card-item">
			<div class="card-img">
				<img src="{$tsConfig.images}/loadImage.gif" data-src="{$f.f_url}" class="rounded w-100" alt="{$f.f_title}">
				<div class="data-information rounded background__level--31">
					<h3>{$f.f_title}</h3>
					<small class="d-block text-white"><i data-feather="clock"></i> {$f.f_date|hace}</small>
					{if $f.f_description}<p>{$f.f_description|truncate:50}</p>{/if}
					<div class="acceder d-flex justify-content-center align-items-center flex-column">
						<a class="text-white" title="Ver {$f.f_title}" href="{$tsConfig.url}/fotos/{$f.user_name}/{$f.foto_id}/{$f.f_title|seo}.html"><i data-feather="eye"></i> Acceder</a>
						<a class="text-white" href="{$tsConfig.url}/perfil/{$f.user_name}"><i data-feather="at-sign"></i> {$f.user_name}</a>
					</div>
				</div>
			</div>
		</div>
	{/foreach}
	</div>
	{if $tsPages.pages > 1}
		<div class="d-flex justify-content-between align-items-center">
			{if $tsPages.prev > 0 && $tsPages.max == false}
				<a href="#" onclick="last_files('{$tsPages.prev}'); return false" class="btn btn-info">Anterior</a>
			{else}	
				<a class="poff btn btn-scondary">Anterior</a>
			{/if}
			<span class="position-relative">
				<b id="c_soporte">Pagina {$tsPages.prev+1} de {$tsPages.pages}</b>
				<div id="com_gif" style="top:0;display:none;" class="loading loading-lg loading-slow success position-absolute w-100"></div>
			</span>
			{if $tsPages.next <= $tsPages.pages}
				<a href="#" onclick="last_files('{$tsPages.next}'); return false" class="btn btn-info">Siguiente</a>
			{else}
				<a class="poff float-end btn btn-sm btn-scondary">Siguiente</a>		
			{/if}
		</div>
	{/if}
	{else}
	<div class="alert alert-warning text-center fw-bold">
		<h4>No hay imagenes</h4>
	</div>
	{/if}
</div>
<!--<div class="d-block">
	{if $tsLastFotos.data > 10}P&aacute;ginas: {$tsLastFotos.pages}{/if}
</div>-->