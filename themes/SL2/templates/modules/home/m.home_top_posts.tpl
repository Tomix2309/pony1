<div class="box-lateral">
   <div class="box-header">Post m&aacute;s destacado <i data-feather="activity"></i></div>
   <div class="box-body">
      {if empty($tsTopPost)}
         <div class="empty">No hay posts destacados</div>
      {else}
         {foreach $tsTopPost item=p}
         <div class="destacado">
            <img src="{if $p.post_portada}{$p.post_portada}{else}{$p.post_cover}{/if}" alt="{$p.post_title}">
            <span class="position-absolute badge badge-info">{$p.c_nombre}</span>
            <div class="position-absolute data">
               <a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" class="d-block h6 text-light post">{$p.post_title}</a>
               <a href="{$tsConfig.url}/perfil/{$p.user_name}" class="small text-light usuario">{$p.user_name}</a>
            </div>
         </div>
         {/foreach}
      {/if}
   </div>
</div>