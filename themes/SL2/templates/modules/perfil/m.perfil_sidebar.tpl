<div class="user-level box-perfil shadow-3 rounded">
   <ul class="list-unstyled">
      <li>
         <strong>{$tsInfo.stats.user_puntos}</strong>
         <span>Puntos</span>
      </li>
      <li>
      	<strong>{$tsInfo.stats.user_posts}</strong>
      	<span>Posts</span>
      </li>
      <li>
      	<strong>{$tsInfo.stats.user_comentarios}</strong>
      	<span>Comentarios</span>
      </li>
      <li>
      	<strong>{$tsInfo.stats.user_fotos}</strong>
      	<span>Fotos</span>
      </li>
   </ul>
</div>		
{if $tsGeneral.fotos_total > 0}
<div id="perfil-foto-bar" class="box-perfil shadow-3 rounded">
   <div class="box-title">
      <h3>&Uacute;ltimas fotos</h3>
      <span>{$tsGeneral.fotos_total}</span>
   </div>
   <ul class="list-unstyled">
   {foreach from=$tsGeneral.fotos item=f key=i}
      {if $f.foto_id}
         <li>
            <a href="{$tsConfig.url}/fotos/{$tsInfo.nick}/{$f.foto_id}/{$f.f_title|seo}.html" title="{$f.f_title}">
               <img class="w-100" alt="{$f.f_title}" src="{$f.f_url}"/>
            </a>
         </li>
      {/if}
   {/foreach}
   </ul>
</div>
{/if}				
<div class="box-perfil shadow-3 rounded">
	<div class="box-title">
      <h3>Medallas</h3>
      <span>{$tsGeneral.m_total}</span>
   </div>
   {if $tsGeneral.m_total}
      <ul class="list-unstyled">
         {foreach from=$tsGeneral.medallas item=m}
   			<img src="{$tsConfig.images}/icons/med/{$m.m_image}_32.png" title="{$m.m_title}"/>
         {/foreach}
      </ul>
      {if $tsGeneral.m_total >= 21}
         <a href="#medallas" onclick="perfil.load_tab('medallas', $('#medallas'));" class="d-block text-dark text-center p-2 text-uppercase small">Ver m&aacute;s &raquo;</a>
      {/if}
   {else}
      <div class="alert alert-warning text-center">No tiene medallas</div>
   {/if}
</div>
<div class="box-perfil shadow-3 rounded">
   <div class="box-title">
      <h3>Seguidores</h3>
      <span>{$tsInfo.stats.user_seguidores}</span>
   </div>
   {if $tsGeneral.segs.data}
      <ul class="list-unstyled lista-user">
      {foreach from=$tsGeneral.segs.data item=s}
         <li>
            <a href="{$tsConfig.url}/perfil/{$s.user_name}">
               <img src="{$tsConfig.url}/files/avatar/{$s.user_id}.webp"/>
               <div>
                  <span>{$s.user_name}</span>
                  <small class="d-block">#{$s.user_id}</small>
               </div>
            </a>
         </li>
      {/foreach}
      </ul>
      {if $tsGeneral.segs.total >= 6}
         <a href="#seguidores" onclick="perfil.load_tab('seguidores', $('#seguidores'));" class="d-block text-dark text-center p-2 text-uppercase small">Ver m&aacute;s &raquo;</a>
      {/if}
   {else}
      <div class="alert alert-warning text-center">No tiene seguidores</div>
   {/if}
</div>
<div class="box-perfil shadow-3 rounded" style="border-bottom: none;">
   <div class="box-title">
      <h3>Siguiendo</h3>
      <span>{$tsGeneral.sigd.total}</span>
   </div>
   {if $tsGeneral.sigd.data}
      <ul class="list-unstyled lista-user">
      {foreach from=$tsGeneral.sigd.data item=s}
         <li>
            <a href="{$tsConfig.url}/perfil/{$s.user_name}">
               <img src="{$tsConfig.url}/files/avatar/{$s.user_id}.webp"/>
               <div>
                  <span>{$s.user_name}</span>
                  <small class="d-block">#{$s.user_id}</small>
               </div>
            </a>
         </li>
      {/foreach}
      </ul>
      {if $tsGeneral.sigd.total >= 6}
         <a href="#siguiendo" onclick="perfil.load_tab('siguiendo', $('#siguiendo'));" class="d-block text-dark text-center p-2 text-uppercase small">Ver m&aacute;s &raquo;</a>
      {/if}
   {else}
      <div class="alert alert-warning text-center">No sigue usuarios</div>
   {/if}
</div>