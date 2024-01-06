<div class="p-2">
	<span class="font-weight-light d-block mb-2">
		<a href="javascript:cerrarBus()" class="float-end d-block text-center text-danger h3 bg-dark circle" style="width:26px;height:26px;font-size:26px;line-height:24px;" id="cerrar">&times;</a>
		<b class="font-weight-normal">Se han encontrado <b>{$tsTotal}</b> resultados{if $tsWord != ''} "<b class="text-uppercase fw-bolder text-red"><u>{$tsWord}</u></b>"{/if}
	</span>
	<div class="resuS">
      {if $tsResultados}
	      {foreach $tsResultados item=p}
	      	<div class="posts rounded shadow-4 bg-white overflow-hidden position-relative">
	      		<img onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html'" class="w-100 img-fit-cover loading__lazyload" src="{$tsConfig.images}/gif-cargando-sin-fondo-8.gif" data-src="{if $p.post_portada}{$p.post_portada}{else}{$p.post_cover}{/if}" alt="{$p.post_title}">
	      		<a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" class="fw-bolder text-dark d-block p-2">{$p.post_title|truncate:36}</a>
	      		<a href="{$tsConfig.url}/posts/{$p.c_seo}/" class="cat position-absolute top-2 left-0 bg-dark py-1 px-2 text-orange fw-bolder">{$p.c_nombre}</a>
	      	</div>
	      {/foreach}
	   {else}
	   	<div class="alert alert-warning text-center">No se encontró nada con <b>{$tsWord}</b></div>
	  	{/if}
   </div>
   <span class="d-block text-center mt-2 py-2">
   	<a class="btn btn-success circle" href="{$tsConfig.url}/buscador/?q={$tsWord|replace:' ':'+'}&e=web&cat=-1&autor=">Buscar más</a>
   </span>
</div>
<script>
$(document).ready(function(){
	$('img[data-src]').lazyload({
		effect: 'fadeIn', 
		gravity: 1000
	})
	.removeClass('loading__lazyload')
	.addClass('lazyload');
});
</script>
<style>
#results {
  position: absolute;
  top: 40px;
  right: 0;
  padding: 10px 10px 0 10px;
  width: 100%;
  background-color: #EEE8;
  backdrop-filter: blur(5px);
}
#results .resuS {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  grid-gap: 0 20px;
}
#results .resuS .posts {
	height: 160px;
	font-size: 13px;
}
#results .resuS .posts > img {
	height: 100px;
}
#results .resuS .posts .cat {
	font-size: 10px!important;
}
</style>