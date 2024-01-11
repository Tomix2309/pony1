<div class="box-lateral">
   <div class="box-header">&Uacute;ltimos comentarios <i data-feather="message-circle"></i></div>
   <div class="box-body">
      {foreach from=$tsLastComments item=c}
         <li class="d-flex justify-content-start align-items-center mb-2">
            <img src="{$tsConfig.url}/files/avatar/{$c.c_user}.webp" alt="{$c.user_name}" class="avatar avatar-rounded me-2">
            <span class="d-block">
               {if $tsUser->is_admod && $tsConfig.c_see_mod == 1 && $tsFoto.f_status != 0 || $tsFoto.user_activo == 0}<a href="{$tsConfig.url}/perfil/{$tsUser->getUsername($c.c_user)}" class="text-capitalize small fw-bold" style="color: {if $c.user_activo == 0}brown {elseif $c.f_status == 1}purple {elseif $c.f_status == 2}red{else} var(--dark){/if};" title="{if $c.user_activo == 0}El autor del comentario tiene la cuenta desactivada {elseif $c.f_status == 1}La foto se encuentra oculta {elseif $c.f_status == 2}La foto se encuentra eliminada{else} Visitar perfil{/if}">{/if}{$tsUser->getUsername($c.c_user)}
               {if $tsUser->is_admod && $tsConfig.c_see_mod == 1 && $tsFoto.f_status != 0 || $tsFoto.user_activo == 0}</a>{/if}
               <a class="d-block text-dark" title="Ir al comentario #{$c.cid}" href="{$tsConfig.url}/fotos/{$c.user_name}/{$c.foto_id}/{$c.f_title|seo}.html#div_cmnt_{$c.cid}">{$c.f_title|truncate:24}</a>
            </span>
         </li>
      {/foreach}
   </div>
</div>
{include "modules/m.global_ads_300.tpl"}
<div class="box-lateral">
   <div class="box-header">Estad&iacute;sticas <i data-feather="activity"></i></div>
   <div class="box-body">
      <ul>
         <li class="d-flex justify-content-between align-items-center py-2">
            <span>Miembros</span>
            <span class="badge badge-info shadow">{$tsStats.stats_miembros}</span>
         </li>
         <li class="d-flex justify-content-between align-items-center py-2">
            <span>Fotos</span>
            <span class="badge badge-info shadow">{$tsStats.stats_fotos}</span>
         </li>
         <li class="d-flex justify-content-between align-items-center py-2">
            <span>Comentarios</span>
            <span class="badge badge-info shadow">{$tsStats.stats_foto_comments}</span>
         </li>
      </ul>
   </div>
</div>