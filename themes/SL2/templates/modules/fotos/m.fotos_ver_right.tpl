<div class="box-lateral">
   <div class="box-header">Fotos de {$tsFoto.user_name}</div>
   <div class="box-body">
      <ul id="v_album">
         {foreach from=$tsUFotos item=f}
            <li class="position-relative">
               <a href="{$tsConfig.url}/fotos/{$f.user_name}/{$f.foto_id}/{$f.f_title|seo}.html">
                  <img src="{$f.f_url}" class="w-100" title="{$f.f_title}" />
                  <span class="position-absolute badge badge-info">{$f.f_date|date_format:"%d.%m.%y"}</span>
               </a>
            </li>
         {/foreach}
      </ul>
      <a href="{$tsConfig.url}/fotos/{$tsFoto.user_name}" class="btn btn-block btn-success">Ver todas</a>
   </div>
</div>
<div class="box-lateral">
   <div class="box-header">Seguidores</div>
   <div class="box-body">
      {if $tsFFotos}
      <ul id="v_album">
         {foreach from=$tsFFotos item=f}
            <li class="position-relative">
               <a href="{$tsConfig.url}/fotos/{$f.user_name}/{$f.foto_id}/{$f.f_title|seo}.html">
                  <img src="{$f.f_url}" class="w-100" title="{$f.f_title}" />
               </a>
               <a href="{$tsConfig.url}/perfil/{$f.user_name}" class="seg position-absolute badge badge-info">{$f.user_name}</a>
            </li>
         {/foreach}
      </ul>
      {else}
         <div class="alert alert-warning">{$tsFoto.user_name} no sigue usuarios o no han subido fotos.</div>
      {/if}
      {if $tsFFotos}<a href="{$tsConfig.url}/fotos/{$tsFoto.user_name}" class="btn btn-block btn-success">Ver todas</a>{/if}
   </div>
</div>
<div class="box-lateral">
   <div class="box-header">Medallas</div>
   <div class="box-body">
      {if $tsFMedallas}
      <ul class="v_album">
         {foreach from=$tsFMedallas item=m}
            <li class="position-relative">
               <img src="{$tsConfig.images}/icons/med/{$m.m_image}_32.png" alt="{$m.m_title}"/>
               <span>{$m.m_title} - {$m.m_description}</span>
            </li>
         {/foreach}
      </ul>
      {else}
         <div class="alert alert-warning">Esta foto no tiene medallas</div>
      {/if}
   </div>
</div>