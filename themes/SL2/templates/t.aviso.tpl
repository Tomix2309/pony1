{include file='sections/main_header.tpl'}

   <div class="hero">
      <div class="hero-body">
         {$tsAviso.mensaje}
         <p>{if $tsAviso.but}
               <a href="{if $tsAviso.link}{$tsAviso.link}{else}{$tsConfig.url}{/if}" class="btn btn-primary">{$tsAviso.but}</a>
            {/if}
            {if $tsAviso.return}
               <input type="button" onclick="history.go(-{$tsAviso.return})" title="Volver" value="Volver" class="btn btn-primary">
            {/if}
         </p>
      </div>
   </div>

{include file='sections/main_footer.tpl'}