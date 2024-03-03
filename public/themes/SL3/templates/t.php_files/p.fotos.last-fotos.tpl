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
	</div>
{else}
	<div class="alert alert-warning text-center fw-bold">
		<h4>No hay imagenes</h4>
	</div>
{/if}
<script>
$(document).ready(() => {
   var myLazyLoad = new LazyLoad({
      elements_selector: '.image',
      use_native: true,
      class_loading: 'lazy-loading'
   })
   myLazyLoad.update();
})
</script>