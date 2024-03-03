{include file='sections/main_header.tpl'}
{include "m.perfil_headinfo.tpl"}
<div class="container my-2">
   <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
         <div class="perfil-main clearfix {$tsGeneral.stats.user_rango.1}">
            <div id="info" pid="{$tsInfo.uid}"></div>
            <div id="perfil_content">
               {if $tsPrivacidad.m.v == false}
                  <div id="perfil_wall" status="activo" class="widget">
                     <div class="emptyData">{$tsPrivacidad.m.m}</div>
                     <script type="text/javascript">
                        perfil.load_tab('info', $('#informacion'));
                     </script>
                  </div>
               {elseif $tsType == 'story'}
                  {include "m.perfil_story.tpl"}
               {elseif $tsType == 'news'}
                  {include "m.perfil_noticias.tpl"}
               {else}
                  {include "m.perfil_muro.tpl"}
               {/if}
            </div>
            <div id="perfil_load" style="display:none;"><div class="loading loading-lg success"></div></div>
         </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
         <div class="perfil-sidebar">
            {include "m.perfil_sidebar.tpl"}
         </div>
      </div>
   </div>
</div>
{include file='sections/main_footer.tpl'}