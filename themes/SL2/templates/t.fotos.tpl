{include file='sections/main_header.tpl'}
<div class="row">
{if $tsAction == ''}
   <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
      <div class="nofio">
         {include "t.php_files/p.fotos.last-fotos.tpl"}
      </div>
   </div>
   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
      {include "$tsModulos/m.fotos_home_sidebar.tpl"}
   </div>
   
{elseif $tsAction == 'agregar' || $tsAction == 'editar'}
   <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
      {include "$tsModulos/m.fotos_add_form.tpl"}
   </div>
   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
      <syntaxis-lazyload ></syntaxis-lazyload>
      <!-- src="{$tsConfig.files}/SyntaxisLite-ico-64.png" -->
      {include "$tsModulos/m.fotos_add_sidebar.tpl"}
   </div>
   
{elseif $tsAction == 'ver'}
   <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
      {include "$tsModulos/m.fotos_ver_content.tpl"}
   </div>
   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
      {include "$tsModulos/m.fotos_ver_right.tpl"}
   </div>
   
{elseif $tsAction == 'album'}
   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      {include "$tsModulos/m.fotos_album.tpl"}
   </div>

{elseif $tsAction == 'favoritas'}
   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="emptyData">En construcci&oacute;n</div>
   </div>
{/if}
</div>
{include file='sections/main_footer.tpl'}