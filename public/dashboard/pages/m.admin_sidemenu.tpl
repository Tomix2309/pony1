 <script type="text/javascript">
	var action_menu = '{$tsAction}';
	//{literal} <-- no borrar
	$(function(){
		if(action_menu != '') $('#a_' + action_menu + ' a').addClass('bg-success-subtle');
		else $('#a_main a').addClass('bg-success-subtle text-success');
	});
</script>
{/literal}
<h4 class="bg-light-subtle fs-5 p-2">General</h4>
<ul class="list-unstyled">
   <li id="a_main"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/">Centro de Administraci&oacute;n</a></li>
   <li id="a_creditos"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/creditos">Soporte y Cr&eacute;ditos</a></li>
</ul>
<h4 class="bg-light-subtle fs-5 p-2">Configuraci&oacute;n</h4>
<ul class="list-unstyled">
	<li id="a_configs"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/configs">Configuraci&oacute;n </a></li>
   <li id="a_temas"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/temas">Temas y apariencia</a></li>
   <li id="a_news"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/news">Noticias</a></li>
   <li id="a_ads"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/ads">Publicidad</a></li>
   <li id="a_socials"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/socials">Redes Sociales</a></li>
</ul>
<h4 class="bg-light-subtle fs-5 p-2">Control</h4>
<ul class="list-unstyled">
	<li id="a_medals"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/medals">Medallas</a></li>
   <li id="a_afs"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/afs">Afiliados</a></li>
	<li id="a_stats"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/stats">Estad&iacute;sticas</a></li>
   <li id="a_blacklist"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/blacklist">Bloqueos</a></li>
   <li id="a_badwords"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/badwords">Censuras</a></li>
</ul>
<h4 class="bg-light-subtle fs-5 p-2">Contenido</h4>
<ul class="list-unstyled">
	<li id="a_posts"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/posts">Todos los Posts</a></li>
   <li id="a_fotos"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/fotos">Todas las Fotos</a></li>
	<li id="a_cats"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/cats">Categor&iacute;as</a></li>
</ul>
<h4 class="bg-light-subtle fs-5 p-2">Usuarios</h4>
<ul class="list-unstyled">
	<li id="a_users"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/users">Todos los Usuarios</a></li>
   <li id="a_sesiones"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/sesiones">Sesiones</a></li>
   <li id="a_nicks"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/nicks">Cambios de Nicks</a></li>
   <li id="a_rangos"><a class="d-block text-light-subtle p-2 rounded" href="{$tsConfig.url}/admin/rangos">Rangos de Usuarios</a></li>
</ul>