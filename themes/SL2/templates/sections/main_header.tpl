<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$Lang_short}" xml:lang="{$Lang_short}">
<head>
<title>{$tsTitle}</title>
{hook 
	name="head" 
	lang="{$Lang}" 
	fonts=["Roboto"] 
	favicon="$tsImagen" 
	css=['SyntaxisLite.min.css'] 
	js=['jquery.min.js', 'jquery.plugins.js', 'acciones.js'] 
	wysibb=true
}
<script type="text/javascript">
var global_data = {
	user_key:'{$tsUser->uid}',
	postid:'{$tsPost.post_id}',
	fotoid:'{$tsFoto.foto_id}',
	img:'{$tsConfig.tema.t_url}/',
	url:'{$tsConfig.url}',
	domain:'{$tsConfig.domain}',
	s_title: '{$tsConfig.titulo}',
	s_slogan: '{$tsConfig.slogan}',
	logueado: '{if $tsUser->is_member != true}no{else}si{/if}',
	avatar: '{$tsUser->avatar}',
}; 
{if $tsNots || $tsMPs && $tsAction}
$(document).ready(() => {
{if $tsNots > 0}notifica.popup({$tsNots});{/if}
{if $tsMPs > 0 && $tsAction != 'leer'}mensaje.popup({$tsMPs});{/if}
});
{/if}
</script>
</head>

<body name="superior" id="body">
{if $tsUser->is_admod == 1}{$tsConfig.install}{/if}
<div id="swf"></div>
<div id="js" style="display:none"></div>
<div id="mydialog" class="background__level--3" style="display:none"></div>
<div class="UIBeeper" id="BeeperBox"></div>
<div id="brandday">
<!-- Menu -->
	{if !$tsMobile}
	<div id="mensaje-top">
	   <ul id="top_news" class="msgtxt">
	      {foreach from=$tsConfig.news key=i item=n}
	        <li id="new_{$i+1}" class="p-2">{$n.not_body}</li>
	      {/foreach}
	   </ul>
	</div>
	{/if}
 	<header class="background" style="background: radial-gradient(circle, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.6) 50%, #000000 100%), url('{$tsStyleAdmin.url}');{$tsStyleAdmin.css}{if $tsMobile}padding: 3rem 0;{/if}">
 		<div class="container d-flex justify-content-{if !$tsMobile}between{else}center{/if} align-items-center">
 			<a href="{$tsConfig.url}/">
 				<h1>{$tsConfig.titulo}</h1>
 				<h5>{$tsConfig.slogan}</h5>
 			</a>
 			{if $tsUser->is_member && !$tsMobile}
 				{include file='sections/head_user.tpl'}
 			{/if}
 		</div>
 	</header>
 	{include file='sections/head_menu.tpl'}
	<div class="wrapper{if $tsPage == 'perfil'} bg-light{else} container{if $tsPage == 'admin' || $tsPage == 'moderacion' || $tsPage == 'posts' || $tsPage == 'files'}-fluid{/if}{/if}{if $tsMobile} pt-2{/if}">