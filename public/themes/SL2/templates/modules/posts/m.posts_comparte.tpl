<div class="syntaxis-social d-flex justify-content-between align-items-center">
	<div class="d-flex justify-content-start align-items-start h5 pt-1">Comparte</div>
	<div class="d-flex justify-content-end align-items-start">
	   {* COMPARTIR EN FACEBOOK *}
	   <a class="social-btn facebook" href="#" onclick="RedSocial('https://www.facebook.com/sharer/sharer.php?u={$tsConfig.url}/posts/{$tsPost.categoria.c_seo}/{$tsPost.post_id}/{$tsPost.post_title|seo}.html'); return false;" alt="Facebook"><i data-feather="facebook"></i></a>
	   {* COMPARTIR EN TWITTER *}
	   <a class="social-btn twitter" href="#" onclick="RedSocial('https://twitter.com/intent/tweet?url={$tsConfig.url}/posts/{$tsPost.categoria.c_seo}/{$tsPost.post_id}/{$tsPost.post_title|seo}.html&text=Te invito a ver este post'); return false;" alt="Twitter"><i data-feather="twitter"></i></a>
	   {* COMPARTIR A MIS SEGUIDORES *}
	   <a class="social-btn lni-share-alt"{if $tsUser->is_member}onclick="notifica.sharePost({$tsPost.post_id});"{else}href="{$tsConfig.url}/registro/"{/if}>
	   	<!-- <span>{$tsPost.post_shared}</span> --><i data-feather="globe"></i>
	   </a>
	</div>
</div>