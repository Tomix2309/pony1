<div class="box-posts-autor">
   <div class="avatar">
      <img title="Ver perfil de {$tsAutor.user_name}" alt="{$tsAutor.user_name}" class="avatar-rounded shadow mb-2 mx-auto" src="{$tsAutor.avatar}"/>
   </div>
   <strong class="d-block text-center mt-2 text-capitalize"><a href="{$tsConfig.url}/perfil/{$tsAutor.user_name}" class="text-dark">{$tsAutor.user_name}</a></strong>
   <span class="d-block text-center mb-1" style="font-size:10px;color:#{$tsAutor.rango.r_color};margin-top:-4px;">{$tsAutor.rango.r_name}</span>
   <span class="d-block text-center my-1 puntos-usuario">
      <i data-feather="plus-circle"></i> {$tsAutor.user_puntos}
   </span>
   <span class="d-block small">Temas: <span class="float-end">{$tsAutor.user_posts}</span></span>
   <span class="d-block my-1 small">Seguidores: <span class="float-end">{$tsAutor.user_seguidores}</span></span>
   <span class="d-block small">Comentarios: <span class="float-end">{$tsAutor.user_comentarios}</span></span>
   <span class="d-block text-center my-2 idpost">ID #{$tsPost.post_id}</span>
</div>
{if $tsAutor.user_id != $tsUser->uid}
<div class="box-posts-autor">
   {if !$tsUser->is_member}
      <a class="btn btn-block btn-info follow_user_post" href="{$tsConfig.url}/registro/">Seguir usuario</a>
   {elseif $tsAutor.user_id != $tsUser->uid}
      <a class="btn btn-block btn-danger unfollow_user_post" onclick="notifica.unfollow('user', {$tsAutor.user_id}, notifica.userInPostHandle, $(this).children('span'))" {if !$tsAutor.follow}style="display: none;"{/if}>Dejar de seguir</a>  
      <a class="btn btn-block btn-info follow_user_post" onclick="notifica.follow('user', {$tsAutor.user_id}, notifica.userInPostHandle, $(this).children('span'))" {if $tsAutor.follow > 0}style="display: none;"{/if}>Seguir usuario</a>
      <a class="btn btn-block btn-dark msg" href="#" title="Enviar mensaje privado" onclick="{if !$tsUser->is_member}registro_load_form();{else}mensaje.nuevo('{$tsAutor.user_name}','','','');{/if}return false"><span>Enviar Mp</span></a>
    {/if}
</div>
{/if}
{if $tsUser->is_admod || $tsUser->permisos.modu || $tsUser->permisos.mosu}
<div class="box-posts-autor">
   <a class="text-dark d-block" href="{$tsConfig.url}/moderacion/buscador/1/1/{$tsPost.post_ip}" target="_blank">{$tsPost.post_ip}</a>
   {if $tsUser->is_admod == 1}
      <a class="text-info d-block" href="{$tsConfig.url}/admin/users?act=show&amp;uid={$tsAutor.user_id}">Editar Usuario</a>
   {/if}
   {if $tsAutor.user_id != $tsUser->uid} 
      <a class="text-warning d-block" href="#" onclick="mod.users.action({$tsAutor.user_id}, 'aviso', false); return false;">Alertar Usuario</a>
   {/if}
   {if $tsAutor.user_id != $tsUser->uid && $tsUser->is_admod || $tsUser->permisos.modu || $tsUser->permisos.mosu}
      {if $tsAutor.user_baneado}
         {if $tsUser->is_admod || $tsUser->permisos.modu}
            <a class="text-success d-block" href="#" onclick="mod.reboot({$tsAutor.user_id}, 'users', 'unban', false); $(this).remove(); return false;">Desbanear Usuario</a>
         {/if}
      {else}
         {if $tsUser->is_admod || $tsUser->permisos.mosu}
            <a class="text-danger d-block" href="#"  class="" onclick="mod.users.action({$tsAutor.user_id}, 'ban', false); $(this).remove(); return false;">Banear Usuario</a>
         {/if}
      {/if}
   {/if}
</div>
{/if}