{if $tsLastFotos.data}
	<div class="galeria">
		<div class="galeria-content">
			{foreach from=$tsLastFotos.data item=f}
				<div class="galeria-item position-relative overflow-hidden rounded shadow">
					<figure class="m-0">
						<img src="{$tsConfig.images}/loadImage.gif" data-src="{$f.f_url}" class="image w-100 h-100 object-fit-cover" loading="lazy" alt="{$f.f_title}">
					</figure>
					<div class="galeria-data p-2 px-3 position-absolute w-100">
						<small class="d-block text-white">{$f.f_date|hace}</small>
						<h3 class="fs-4 m-0 w-100 d-block">{$f.f_title}</h3>
						{if $f.f_description}<p class="text-truncate d-block">{$f.f_description}</p>{/if}
					</div>
					<div class="galeria-user position-absolute d-flex justify-content-start align-items-center gap-2">
						<img src="{$tsConfig.images}/loadImage.gif" data-src="{$f.f_avatar}" class="image object-fit-cover rounded-circle" loading="lazy" alt="{$f.user_name}">
						<span>{$f.user_name}</span>			
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
	</div>
{else}
	<div class="alert alert-danger text-center m-3">
		<h4>Lo lamento, aún no hay fotos!</h4>
	</div>
{/if}