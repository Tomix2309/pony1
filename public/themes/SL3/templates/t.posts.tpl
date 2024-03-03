{include file='sections/main_header.tpl'}
<a name="cielo"></a>
<!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.0.0/build/styles/atelier-lakeside-dark.min.css">
<script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.0.0/build/highlight.min.js"></script> -->¿

{if $tsPost.post_status > 0 || $tsAutor.user_activo != 1}
   <div class="alert alert-{if $tsPost.post_status == 2}danger{elseif $tsPost.post_status == 3}info{else}warning{/if} mb-3 text-center">Este post se encuentra {if $tsPost.post_status == 2}eliminado{elseif $tsPost.post_status == 1} inactivo por acomulaci&oacute;n de denuncias{elseif $tsPost.post_status == 3} en revisi&oacute;n{elseif $tsPost.post_status == 3} en revisi&oacute;n{elseif $tsAutor.user_activo != 1} oculto porque pertenece a una cuenta desactivada{/if}, t&uacute; puedes verlo porque {if $tsUser->is_admod == 1}eres Administrador{elseif $tsUser->is_admod == 2}eres Moderador{else}tienes permiso{/if}.</div>
{/if}
<div class="row">
   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
      {include "m.post_info.tpl"}
      {include "m.posts_related.tpl"}
   </div>
   <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
      {include "m.posts_content.tpl"}
      {include "m.posts_pagina.tpl"}
      <a name="comentarios"></a>
      {include "m.posts_comments.tpl"}
      <a name="comentarios-abajo"></a>
   </div>
   <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
      {include "m.posts_autor.tpl"}
      <div class="post-info">
         {if $tsRelated}
         <ul class="list-unstyled">
            {foreach from=$tsRelated item=p}
               <li class="d-block mb-3">
                  <a title="{$p.post_title|truncate}" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">
                     <img class="rounded shadow w-100" height="220" src="{if $p.post_portada}{$p.post_portada}{elseif $p.post_cover}{$p.post_cover}{/if}"/>
                  </a>
               </li>
            {/foreach}
         </ul>
      {else}
         <div class="alert alert-warning text-center">No se encontraron posts relacionados.</div>
      {/if}
      </div>
   </div>
</div>
{if !$tsUser->is_member}
   <div class="alert alert-warning text-center">Para poder comentar necesitas estar <a href="{$tsConfig.url}/registro/" class="fw-bold">Registrado.</a> O.. ya tienes usuario? <a href="javascript:open_login_box('open')" class="fw-bold">Logueate!</a></div>
{elseif $tsPost.block > 0}
   <div class="alert alert-danger text-center">&iquest;Te has portado mal? {$tsPost.user_name} te ha bloqueado y no podr&aacute;s comentar sus post.</div>
{/if}

{include file='sections/main_footer.tpl'}