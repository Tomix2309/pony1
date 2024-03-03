<div id="perfil_wall" status="activo" >
   <script type="text/javascript">
      muro.stream.total = {$tsMuro.total};
   </script>
   <div id="perfil-form" class="widget">
      {if $tsPrivacidad.mf.v == true}
         {include "m.perfil_muro_form.tpl"}
      {else}
         <div class="alert alert-light">{$tsPrivacidad.mf.m}</div>
      {/if}
   </div>
	<div class="widget bg-none" id="perfil-wall">
      <div id="wall-content">
         {include "m.perfil_muro_story.tpl"}
      </div>
      <!-- more -->
      {if $tsMuro.total >= 10}
         <div class="more-pubs">
            <div class="text-center alert alert-success">
               <a href="#" onclick="muro.stream.loadMore('wall'); return false;" class="text-white">Publicaciones m&aacute;s antiguas</a>
               <span class="loading loading-lg" style="display:none;"></span>
            </div>
         </div>
      {elseif $tsMuro.total == 0 && $tsUser->is_member}
         <div class="alert alert-info text-center">Este usuario no tiene comentarios, se el primero.</div>
      {/if}
   </div>
</div>