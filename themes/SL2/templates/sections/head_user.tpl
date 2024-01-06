<div class="nav-user d-flex justify-content-end align-items-center">
	<!-- Acá se mostrarán las notificaciones -->
	<div class="position-relative monitor">
		<a href="{$tsConfig.url}/monitor/" onclick="notifica.last(); return false" name="Monitor" class="svgIcon"><i data-feather="bell"></i></a>
		<div class="notis-panel" id="mon_list" style="display:none;">
         <strong onclick="location.href='{$tsConfig.url}/monitor/'">Notificaciones</strong>
         <ul></ul>
         <a href="{$tsConfig.url}/monitor/" class="ver-mas text-info d-block text-center p-1 small">Ver m&aacute;s notificaciones</a>
      </div>
	</div>
	<!-- Fin de la línea -->
	<!-- Acá se mostrarán los mensajes -->
	<div class="position-relative mensajes">
		<a href="{$tsConfig.url}/mensajes/" onclick="mensaje.last(); return false" title="Mensajes Personales" name="Mensajes" class="svgIcon"><i data-feather="mail"></i></a>
		<div class="notis-panel" id="mp_list" style="display:none;">
			<strong onclick="location.href='{$tsConfig.url}/mensajes/'">Mensajes</strong>
			<ul id="boxMail"></ul>
			<a href="{$tsConfig.url}/mensajes/" class="ver-mas text-info d-block text-center p-1 small">Ver todos los mensajes</a>
		</div>
	</div>
	<!-- Fin de la línea -->
	{if $tsAvisos}
	<!-- Acá se mostrarán las alertas -->
	<div class="position-relative"><a title="Tiene{if $tsAvisos != 1}s{/if} {$tsAvisos} aviso{if $tsAvisos != 1}s{/if}" href="{$tsConfig.url}/mensajes/avisos" data-avisos="{$tsAvisos}" class="svgIcon"><i data-feather="alert-triangle"></i></a></div>
   {/if}
	<!-- Fin de la línea -->
	<!-- Acá se mostrarán las opciones del usuario -->
	<div class="position-relative">
		<a href="{$tsConfig.url}/perfil/{$tsUser->nick}" onclick="menu.last(); return false" name="Menu" class="text-capitalize d-flex justify-content-end align-items-center fw-bolder">{$tsUser->nick} 
			<img src="{$tsUser->avatar}" alt="{$tsUser->nick}" class="avatar-head shadow avatar ml-2 avatar-circle">
		</a>
		<div class="notis-panel" id="menu_list" style="display:none;">
			<ul>
				<li class="user position-relative">
		         <span class="d-block">
		         	<a class="nombre h4 text-capitalize" title="Mi Perfil" href="{$tsConfig.url}/perfil/{$tsUser->info.user_name}">{if $tsUser->nombre}{$tsUser->nombre}{else}{$tsUser->nick}{/if}</a>
		         	<a class="small d-block fw-bold" title="Mi Correo" href="mailto:{$tsUser->correo}">{$tsUser->correo}</a>
		         </span>
		      </li>
		      {if $tsUser->is_admod == 1}<li class="item"><a class="d-block" title="Gestionar configuracion web" href="{$tsConfig.url}/pages/settings"><i data-feather="sliders"></i> Gestionar configuracion web</a></li>{/if}
		      <li class="item"><a class="d-block" title="Gestionar mi cuenta" href="{$tsConfig.url}/cuenta/"><i data-feather="settings"></i> Gestionar mi cuenta</a></li>
				<li class="item"><a class="d-block" title="Mis Favoritos" href="{$tsConfig.url}/favoritos.php"><i data-feather="star"></i> Mis Favoritos</a></li>
		      <li class="item"><a class="d-block" title="Mis Borradores" href="{$tsConfig.url}/borradores.php"><i data-feather="trash-2"></i> Mis Borradores</a></li>
		      <li class="item"><a class="d-block" href="{$tsConfig.url}/login-salir.php" title="Salir"><i data-feather="log-out"></i> Cerrar sesión</a></li>
	      </ul>
		</div>
	</div>
</div>