<div class="post-info">
	<a class="position-absolute mt-2 ms-2 text-white" href="{$tsConfig.url}/posts/{$tsPost.categoria.c_seo}/">
		<span data-cat="{$tsPost.categoria.c_seo|truncate:2:''}"></span>
	</a>
	<div class="post-portada">
		{image type="portada" alt="{$tsPost.post_title}" src="{$tsPost.post_portada}" class="rounded shadow w-100" style="object-fit:cover;height: 340px;"}
	</div>
	<div class="post-descripcion mt-1 px-2 py-3">
		<h1 class="fw-bolder d-block h5 titulo_post">{$tsPost.post_title}</h1>
		<div class="small d-block mb-1 font-italic" style="margin-top: -6px;"> Creado {$tsPost.post_date|hace}</div>
		<div class="d-block small"> <span>Seguidores:</span> {$tsPost.post_seguidores} </div>
		<div class="d-block my-1 small"> <span>Favoritos:</span> {$tsPost.post_favoritos}</div>
		<div class="d-block small"> <span>Puntos:</span> {$tsPost.post_puntos}</div>
		<div class="d-block my-1 small"> <span>Medallas:</span> {$tsPost.m_total} </div>
	</div>
	<div class="tagsplus">
      {foreach from=$tsPost.post_tags key=i item=tag}
         <a rel="tag" class="fw-bolder text-dark bg-light text-uppercase" href="{$tsConfig.url}/buscador/?q={$tag|seo}&e=tags">{$tag}</a> {if $i < $tsPost.n_tags}{/if}
      {/foreach}
	</div>
</div>
	{include "modules/m.global_ads_160.tpl"}