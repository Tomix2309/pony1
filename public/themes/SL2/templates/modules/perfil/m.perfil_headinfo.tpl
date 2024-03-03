<div class="header__user bg-body-tertiary rounded">
   <div class="header__user--cover rounded shadow position-relative" style="background:linear-gradient(to bottom, transparent, transparent, #0002, #000D), url('{$tsPortada.url}');{$tsPortada.styles}">
      <!-- Info extra del usuario -->
      <div class="position-absolute" style="top: 6px;left: 8px;">
         <div class="d-extras d-flex justify-content-start align-items-center">
         {foreach $tsInfo.p_socials key=name item=red}
            {if !empty($red)}
               <a class="extras me-2 py-2 text-light-emphasis rounded shadow" target="_blank" href="{$tsRedes.$name.url}/{$red}" title="{$name|ucfirst}" data-bs-toggle="tooltip" data-bs-title="{$name|ucfirst}"><iconify-icon class="fs-4 pe-none" icon="{$tsRedes.$name.iconify}"></iconify-icon></a>
            {/if}
         {/foreach}
         {if $tsUser->uid != $tsInfo.uid}
            {if $tsUser->is_member}
               <a title="Enviar mensaje privado" class="extras me-2 py-2 text-light-emphasis rounded shadow" href="javascript:mensaje.nuevo('{$tsInfo.nick}','','','')" data-bs-toggle="tooltip" data-bs-title="Enviar mensaje privado"><iconify-icon class="fs-4 pe-none" icon="la:mail-bulk"></iconify-icon></a>
            {/if}
         {/if}
         {if $tsUser->is_admod == 1}
            <a class="extras me-2 py-2 text-light-emphasis rounded shadow" title="Editar usuario" href="{$tsConfig.url}/admin/users?act=show&uid={$tsInfo.uid}" data-bs-toggle="tooltip" data-bs-title="Editar usuario"><iconify-icon class="fs-4 pe-none" icon="la:user-edit"></iconify-icon></a>
         {/if}
            <a class="extras me-2 py-2 text-light-emphasis rounded shadow" title="Cambiar portada" href="javascript:portada.cambiar()" data-bs-toggle="tooltip" data-bs-title="Cambiar portada"><iconify-icon class="fs-4 pe-none" icon="la:brush"></iconify-icon></a>
         </div>
      </div>

   </div>
   <div class="header__user--infodata d-grid gap-3 align-items-center py-3 px-4 position-relative" style="grid-template-columns:160px 1fr auto;">
      <div class="avatar rounded shadow overflow-hidden position-relative">
         <div class="avatar-loading" style="display: none;"></div>
         <img src="{$tsConfig.images}/loadImage.gif" data-src="{$tsInfo.user_avatar}" class="image avatar-big object-fit-cover rounded border-color-{$tsInfo.status.css}" loading="lazy" id="cambiar-foto" alt="{$tsInfo.nick}">
         {if $tsUser->uid == $tsInfo.uid}
            <!-- Botón para cambiar foto -->
            <a href="javascript:avatar.accion.avamodal('{$tsUser->uid}', 0)" class="position-absolute w-100 h-100 top-0 start-0 fw-bold d-flex justify-content-center align-items-center flex-column btn-portada"><iconify-icon class="fs-3" icon="la:camera"></iconify-icon> Cambiar foto</a>
         {/if}
      </div>
      <div class="">
         <span class="d-block text-light fw-bold fs-3 mb-3 text-capitalize">{$tsInfo.nick}</span>
         <small class="d-block">{if $tsInfo.p_nombre}{$tsInfo.p_nombre} &bull; {/if}<span style="color:#{$tsInfo.stats.r_color};">{$tsInfo.stats.r_name}</span>{if $tsInfo.user_pais} &bull; {$tsInfo.user_pais}{/if} <span title="{$tsGeneral.signo.signo_name}">{$tsGeneral.signo.code}</span></small>
         {if $tsInfo.p_mensaje}
            <blockquote class="text-secondary-emphasis fst-italic">
               &ldquo;{$tsInfo.p_mensaje}&rdquo;
            </blockquote>
         {/if}
      </div>
      <!-- Opciones de usuario -->
      {if $tsUser->uid != $tsInfo.uid && $tsUser->is_member}
      <div class="btn-group btn-group-sm" role="group" aria-label="Acciones de usuario">
         {if ($tsUser->is_admod || $tsUser->permisos.mosu) && !$tsInfo.user_baneado}
            <a class="btn btn-danger text-capitalize" title="Suspender" href="#" onclick="mod.users.action({$tsInfo.uid}, 'ban', true); return false;">suspender</a>
         {/if}{if !$tsInfo.user_activo || $tsInfo.user_baneado}
            <a class="btn btn-warning text-capitalize" title="Cuenta {if !$tsInfo.user_activo}desactivada{else}baneada{/if}" href="#">Banear</a>
         {/if}
         <a class="btn btn-{if $tsInfo.block.bid}info{else}secondary{/if} text-capitalize" title="{if $tsInfo.block.bid}Desbloquear{else}Bloquear{/if}" href="javascript:bloquear({$tsInfo.uid}, {if $tsInfo.block.bid}false{else}true{/if}, 'perfil')" id="bloquear_cambiar">Bloquear</a>
         <a class="btn btn-warning text-capitalize" title="Denunciar" href="#" onclick="denuncia.nueva('usuario',{$tsInfo.uid}, '', '{$tsInfo.nick}'); return false">Denunciar</a>
         <a  class="btn btn-danger text-capitalize unfollow_user_post" onclick="notifica.unfollow('user', {$tsInfo.uid}, notifica.userInPostHandle, $(this).children('span'))" {if $tsInfo.follow == 0}style="display: none;"{/if}>Dejar de seguir</a>
         <a class="btn btn-success text-capitalize follow_user_post" onclick="notifica.follow('user', {$tsInfo.uid}, notifica.userInPostHandle, $(this).children('span'))" {if $tsInfo.follow == 1}style="display: none;"{/if}>Seguir</a>       
      </div>
      {/if}
   </div>
   <div class="menu-tabs-perfil pb-3">
      <ul id="tabs_menu" class="nav nav-pills justify-content-center">
         {if $tsType == 'news' || $tsType == 'story'}
            <li class="nav-item"><a class="nav-link active" href="javascript:perfil.load_tab('news', this)">{if $tsType == 'story'}Publicaci&oacute;n{else}Noticias{/if}</a></li>
         {/if}
         <li class="nav-item"><a class="nav-link{if $tsType == 'wall'} active{/if}" href="javascript:perfil.load_tab('wall', this)">Muro</a></li>
         <li class="nav-item"><a class="nav-link" href="javascript:perfil.load_tab('actividad', this)" id="actividad">Actividad</a></li>
         <li class="nav-item"><a class="nav-link" href="javascript:perfil.load_tab('info', this)" id="informacion">Informaci&oacute;n</a></li>
         <li class="nav-item"><a class="nav-link" href="javascript:perfil.load_tab('posts', this)">Posts</a></li>
         <li class="nav-item"><a class="nav-link" href="javascript:perfil.load_tab('seguidores', this)" id="seguidores">Seguidores</a></li>
         <li class="nav-item"><a class="nav-link" href="javascript:perfil.load_tab('siguiendo', this)" id="siguiendo">Siguiendo</a></li>
         <li class="nav-item"><a class="nav-link" href="javascript:perfil.load_tab('medallas', this)">Medallas</a></li>
      </ul>
   </div>
</div>