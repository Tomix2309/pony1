{include file='sections/main_header.tpl'}
<div class="row">
   {include "$tsModulos/m.mensajes_menu.tpl"}
   <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
      <div style="display: none;" id="m-mensaje"></div>
      <div class="boxy">
         <div class="boxy-title">
            <h3>Mensajes</h3>
            <form method="get" action="{$tsConfig.url}/mensajes/search/">
               <input type="text" name="qm" placeholder="Buscar en Mensajes" title="Buscar en Mensajes" value="{$tsMensajes.texto}" class="search_mp form-input"/>
            </form>
         </div>
         <div class="boxy-content" style="padding:0" id="mensajes">
            {if $tsAction == '' || $tsAction == 'enviados' || $tsAction == 'respondidos' || $tsAction == 'search'}
               {include "$tsModulos/m.mensajes_list.tpl"}
            {elseif $tsAction == 'leer'}
               {include "$tsModulos/m.mensajes_leer.tpl"}
            {elseif $tsAction == 'avisos'}
               {include "$tsModulos/m.mensajes_avisos.tpl"}
            {/if}
			</div>
      </div>
   </div>
</div>                
{include file='sections/main_footer.tpl'}