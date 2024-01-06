<div class="box-lateral">
   <div class="box-header">{if $tsFUser.0 == $tsUser->uid}Mi galer&#237;a de fotos{else}Fotos de {$tsFUser.1}{/if}</div>
   <div class="box-body">
      <div class="masonry list-unstyled">
         {foreach from=$tsFotos.data item=f}
            <div class="card-img">
               <img src="{$tsConfig.images}/gif-cargando-sin-fondo-8.gif" data-src="{$f.f_url}" class="rounded w-100" alt="{$f.f_title}">
               <div class="data-information rounded">
                  <h3>{$f.f_title}</h3>
                  <small class="d-block text-white"><i data-feather="clock"></i> {$f.f_date|hace}</small>
                  {if $f.f_description}<p>{$f.f_description|truncate:50}</p>{/if}
                  <div class="acceder d-flex justify-content-center align-items-center flex-column">
                     <a class="text-white" title="Ver {$f.f_title}" href="{$tsConfig.url}/fotos/{$f.user_name}/{$f.foto_id}/{$f.f_title|seo}.html"><i data-feather="eye"></i> Acceder</a>
                     <a class="text-white" href="{$tsConfig.url}/perfil/{$f.user_name}"><i data-feather="at-sign"></i> {$f.user_name}</a>
                  </div>
               </div>
            </div>
         {/foreach}
      </div>
      <div class="d-flex justify-content-center align-items-center">
         {if $tsFotos.pages.prev}
            <a class="btn btn-success" href="{$tsConfig.url}/fotos/{$tsFUser.1}/{$tsFotos.pages.prev}">&laquo; Anterior</a>
         {/if}
         {if $tsFotos.pages.next}
            <a class="btn btn-success" href="{$tsConfig.url}/fotos/{$tsFUser.1}/{$tsFotos.pages.next}">Siguiente &raquo;</a>
         {/if}
      </div>
   </div>
</div>