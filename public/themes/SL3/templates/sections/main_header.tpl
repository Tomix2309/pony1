<!DOCTYPE html>
<html data-bs-theme="{$mode}" xmlns="http://www.w3.org/1999/xhtml" lang="{$Lang_short}" xml:lang="{$Lang_short}">
<head>
<title>{$tsTitle}</title>
{metadatos facebook=true twitter=true robots=false sitemap=false lang='es'}
{googlefonts fonts="Roboto"}
{jsdelivr type="css" files=['bootstrap','driver','croppr','pace']}
{jsdelivr type="js" files='jquery-beta'}
{hook css=['SyntaxisLite.min.css'] js=['acciones.js'] wysibb=true global=true position="start"}
<script>
$(document).ready(() => {
   var urlBuscar = global_data.url + "/login/";
   $('a[href="' + urlBuscar + '"]').attr({
   	href: urlBuscar + "?redirect=" + rawurlencode(location.href)
   });
});
</script>
</head>

<body name="superior" id="body">
{if $tsUser->is_admod == 1}{$tsConfig.install}{/if}
<div id="swf"></div>
<div id="js" style="display:none"></div>
<div id="mydialog" style="display:none"></div>
<div class="UIBeeper" id="BeeperBox"></div>
<div id="brandday">

	{if !$tsMobile && !empty({$tsConfig.news})}
	<div id="mensaje-top">
	   <ul id="top_news" class="msgtxt">
	      {foreach from=$tsConfig.news key=i item=n}
	        <li id="new_{$i+1}" class="p-2">{$n.not_body}</li>
	      {/foreach}
	   </ul>
	</div>
	{/if}
 	<header class="background position-relative" data-bg-multi="url({$SL2SiteHeader.url})" style="background-color:#232323;{$SL2SiteHeader.styles}">
 		<div class="background__level--3 position-absolute w-100 h-100" style="top: 0;
 		left: 0;"></div>
 		<div class="container-fluid position-relative d-flex justify-content-between align-items-center">
 			<a href="{$tsConfig.url}/" class="text-center text-md-start" rel="internal" title="{$tsConfig.titulo} - {$tsConfig.slogan}">
 				<h1>{$tsConfig.titulo}</h1>
 				<h5>{$tsConfig.slogan}</h5>
 			</a>
 			{if $tsUser->is_member}
 				{include file='sections/head_user.tpl'}
 			{/if}
 		</div>
 	</header>
 	<!-- Menu -->
 	{include file='sections/head_menu.tpl'}
	<div class="wrapper container{if $tsPage == 'admin' || $tsPage == 'moderacion'}-fluid{/if} py-2">