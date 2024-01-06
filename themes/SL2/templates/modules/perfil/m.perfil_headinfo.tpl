<div class="content-head-perfil">
   <!-- Incluimos la imagen seleccionada por el usuario -->
<div class="portada-perfil container" style="background-image:url('{$tsPortada.url}');{$tsPortada.css}">
      <!-- Mostramos el avatar del usuario -->
      <div class="avatar {$tsInfo.status.css} position-relative">
         <div style="display: none" class="avatar-loading"></div>
         <img alt="{$tsInfo.nick}" class="avatar-big" src="{$tsConfig.url}/files/avatar/{if $tsInfo.p_avatar}{$tsInfo.uid}{else}avatar{/if}.webp" id="cambiar-foto"/>
         {if $tsUser->uid == $tsInfo.uid}
         <!-- Botón para cambiar foto -->
         <a href="javascript:avatar.accion.avamodal('{$tsUser->uid}', 0)" class="btn-portada"><i data-feather="camera"></i> Cambiar foto</a>
         {/if}
      </div>
      {if $tsUser->uid == $tsInfo.uid}
      <!-- Botón para cambiar la portada -->
      <a href="{$tsConfig.url}/pages/portada/" title="¿Comó cambiar portada?" style="margin-bottom: 35px;background-color:rgba(0, 0, 0, 0.493)" class="btn-portada" id="cambiar-portada"><i data-feather="help-circle"></i></a>
      <a href="javascript:portada.cambiar('{$tsUser->uid}')" style="background-color:#0004" class="btn-portada" id="cambiar-portada">Cambiar portada</a>
      {/if}

      <!-- Info extra del usuario -->
      <div class="position-absolute" style="top: 6px;left: 8px;">
         <div class="d-extras">
         {if $tsUser->uid != $tsInfo.uid}
            {if $tsUser->is_member}
               <a title="Enviar mensaje privado" class="btn-options-extras" href="#" onclick="mensaje.nuevo('{$tsInfo.nick}','','',''); return false"><i data-feather="mail"></i></a>
            {/if}
         {/if}
         {if $tsInfo.p_socials.f}
            <a class="btn-options-extras" target="_blank" href="http://www.facebook.com/{$tsInfo.p_socials.f}" title="Facebook"><i data-feather="facebook"></i></a>
         {/if}
         {if $tsInfo.p_socials.t}
            <a class="btn-options-extras" target="_blank" href="http://www.twitter.com/{$tsInfo.p_socials.t}" title="Twitter"><i data-feather="twitter"></i></a>
         {/if}
         {if $tsInfo.p_socials.i}
            <a class="btn-options-extras" target="_blank" href="http://www.instagram.com/{$tsInfo.p_socials.i}" title="Instragram"><i data-feather="instagram"></i></a>
         {/if}
         {if $tsUser->is_admod == 1}
            <a class="btn-options-extras" title="Editar usuario" href="#" onclick="location.href = '{$tsConfig.url}/admin/users?act=show&amp;uid={$tsInfo.uid}'"><i data-feather="edit-2"></i></a>
         {/if}
         </div>
      </div>
      <!-- Opciones de usuario -->
      {if $tsUser->uid != $tsInfo.uid && $tsUser->is_member}
      <div class="position-absolute" style="top: 6px; right: 8px">
         {if ($tsUser->is_admod || $tsUser->permisos.mosu) && !$tsInfo.user_baneado}
            <a class="btn rounded btn-sm btn-gradient-one text-capitalize" title="Suspender" href="#" onclick="mod.users.action({$tsInfo.uid}, 'ban', true); return false;">suspender</a>
         {/if}{if !$tsInfo.user_activo || $tsInfo.user_baneado}
            <a class="btn rounded btn-sm btn-gradient-{if !$tsInfo.user_activo}two{else}seven{/if} text-capitalize" title="Cuenta {if !$tsInfo.user_activo}desactivada{else}baneada{/if}" href="#">banear</a>
         {/if}
         <a class="btn btn-{if $tsInfo.block.bid}info{else}secondaty{/if} btn-sm text-capitalize rounded" title="{if $tsInfo.block.bid}Desbloquear{else}Bloquear{/if}" href="javascript:bloquear({$tsInfo.uid}, {if $tsInfo.block.bid}false{else}true{/if}, 'perfil')" id="bloquear_cambiar">bloquear</a>
         <a class="btn btn-warning btn-sm text-capitalize rounded" title="Denunciar" href="#" onclick="denuncia.nueva('usuario',{$tsInfo.uid}, '', '{$tsInfo.nick}'); return false">Denunciar</a>
         <a  class="btn btn-danger btn-sm text-capitalize rounded unfollow_user_post" onclick="notifica.unfollow('user', {$tsInfo.uid}, notifica.userInPostHandle, $(this).children('span'))" {if $tsInfo.follow == 0}style="display: none;"{/if}>Dejar de seguir</a>
         <a class="btn btn-success btn-sm text-capitalize rounded follow_user_post" onclick="notifica.follow('user', {$tsInfo.uid}, notifica.userInPostHandle, $(this).children('span'))" {if $tsInfo.follow == 1}style="display: none;"{/if}>Seguir</a>       
      </div>
      {/if}

   </div>
   <div class="d-block text-center p-0 m-0 position-relative">
      <span class="d-block fw-bold h4 text-capitalize">{$tsInfo.nick}</span>
      <small class="d-block" style="margin-top:-5px;">{if $tsInfo.p_nombre}{$tsInfo.p_nombre} &bull; {/if}<span style="color:#{$tsInfo.stats.r_color};">{$tsInfo.stats.r_name}</span>{if $tsInfo.user_pais} &bull; {$tsInfo.user_pais}{/if} <span title="{$tsGeneral.signo.signo_name}">{$tsGeneral.signo.code}</span></small>
   </div>
   <div class="menu-tabs-perfil">
      <ul id="tabs_menu" class="container list-unstyled d-flex justify-content-center align-items-center">
         {if $tsType == 'news' || $tsType == 'story'}
            <li class="selected"><a href="#" onclick="perfil.load_tab('news', this); return false">{if $tsType == 'story'}Publicaci&oacute;n{else}Noticias{/if}</a></li>
         {/if}
         <li {if $tsType == 'wall'}class="selected"{/if}><a href="#" onclick="perfil.load_tab('wall', this); return false">Muro</a></li>
         <li><a href="#" onclick="perfil.load_tab('actividad', this); return false" id="actividad">Actividad</a></li>
         <li><a href="#" onclick="perfil.load_tab('info', this); return false" id="informacion">Informaci&oacute;n</a></li>
         <li><a href="#" onclick="perfil.load_tab('posts', this); return false">Posts</a></li>
         <li><a href="#" onclick="perfil.load_tab('seguidores', this); return false" id="seguidores">Seguidores</a></li>
         <li><a href="#" onclick="perfil.load_tab('siguiendo', this); return false" id="siguiendo">Siguiendo</a></li>
         <li><a href="#" onclick="perfil.load_tab('medallas', this); return false">Medallas</a></li>
      </ul>
   </div>
</div>