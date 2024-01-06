{include file='sections/main_header.tpl'}
<link rel="stylesheet" href="{$tsConfig.css}/files.css?{$smarty.now}">
<script src="{$tsConfig.js}/files.js?{$smarty.now}"></script>
{include "$tsModulos/archivos.svg"}
<div class="row">
{if $tsAction == 'new'}
	{include "$tsModulos/f.files_agregar.tpl"}

{elseif $tsAction == 'user'}
   {include "$tsModulos/f.files_user.tpl"}
   {include "$tsModulos/f.files_user_sidebar.tpl"}

{elseif $tsAction == 'ver'}
   {include "$tsModulos/f.files_ver.tpl"}
   {include "$tsModulos/f.files_ver_sidebar.tpl"}

{elseif $tsAction == 'favoritos'}
   {include "$tsModulos/f.files_fav.tpl"}
   {include "$tsModulos/f.files_fav_sidebar.tpl"}

{elseif $tsAction == 'faqs'}
	{include "$tsModulos/f.files_faqs.tpl"}
{/if}
</div>
{include file='sections/main_footer.tpl'}