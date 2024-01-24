{include file='sections/main_header.tpl'}

<div class="container">
	<div class="{if $tsAction != 'descargar'}row {/if}my-3">
	{if $tsAction == '' || $tsAction == 'mis-archivos'}
	   {include "f.files_content.tpl"}
	   {include "f.files_content_sidebar.tpl"}

	{elseif $tsAction == 'subir' || $tsAction == 'descargar'}
	   {include "f.files_$tsAction.tpl"}
	   
	{elseif $tsAction == 'carpeta' || $tsAction == 'encriptado'}
		{include "f.files_carpeta.tpl"}

	{elseif $tsAction == 'ver'}
	   {include "f.files_ver.tpl"}
	   {include "f.files_ver_sidebar.tpl"}

	{elseif $tsAction == 'favoritos'}
	   {include "f.files_fav.tpl"}
	   {include "f.files_fav_sidebar.tpl"}

	{elseif $tsAction == 'faqs'}
		{include "f.files_faqs.tpl"}
	{/if}
	</div>
</div>	
{include file='sections/main_footer.tpl'}