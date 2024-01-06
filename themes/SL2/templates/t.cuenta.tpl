{include file='sections/main_header.tpl'}
<link href="https://cdn.jsdelivr.net/npm/croppr@2.3.1/dist/croppr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/croppr@2"></script>
<script src="{$tsConfig.js}/cuenta.js?{$smarty.now}"></script>
<script>
$(document).ready(() => {
   avatar.uid = '{$tsUser->uid}';
   avatar.current = '{$tsPerfil.avatar}';
   if (typeof location.href.split('#')[1] != 'undefined') 
      $('ul.menu-tab > li > a:contains('+location.href.split('#')[1]+')').click();
});
</script>
<div class="row">
   <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
      <ul class="menu-tab d-flex justify-content-start align-items-center">
         <li{if $tsAccion == ''} class="active"{/if}><a href="{$tsConfig.url}/cuenta/">Cuenta</a></li>
         <li{if $tsAccion == 'perfil'} class="active"{/if}><a href="{$tsConfig.url}/cuenta/perfil">Perfil</a></li>    
         <li{if $tsAccion == 'bloqueados'} class="active"{/if}><a href="{$tsConfig.url}/cuenta/bloqueados">Bloqueados</a></li>
         <li{if $tsAccion == 'clave'} class="active"{/if}><a href="{$tsConfig.url}/cuenta/clave">Cambiar Clave</a></li>
			<li{if $tsAccion == 'nick'} class="active"{/if}><a href="{$tsConfig.url}/cuenta/nick">Cambiar Nick</a></li>
         <li{if $tsAccion == 'config'} class="active"{/if}><a href="{$tsConfig.url}/cuenta/privacidad">Privacidad</a></li>
         <li{if $tsAccion == 'avatar'} class="active"{/if}><a href="{$tsConfig.url}/cuenta/avatar">Avatar</a></li>
      </ul>
      <div id="alerta_guarda" style="display: none;"></div>
      <a name="alert-cuenta"></a>
      <div class="avatares" style="display:none;"></div>
      <form class="horizontal" method="post" action="" name="editarcuenta">
         <input type="hidden" name="pagina" value="{$tsAccion}">
         {include "m.cuenta_$tsAccion.tpl"}
      </form>
   </div>
   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
	   {include "m.cuenta_sidebar.tpl"}
   </div>
</div>             
{include file='sections/main_footer.tpl'}