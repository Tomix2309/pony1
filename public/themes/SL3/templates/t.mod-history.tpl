{include file='sections/main_header.tpl'}
<div class="row">
   <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
      <a href="{$tsConfig.url}/mod-history/" class="btn btn-block mb-2 btn-{if !$tsAction || $tsAction == 'posts'}success{else}warning{/if}">Posts</a>
      <a href="{$tsConfig.url}/mod-history/fotos/" class="btn btn-block mb-2 btn-{if $tsAction == 'fotos'}success{else}warning{/if}">Fotos</a>
   </div>
   <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
		<div id="resultados" style="width:100%">
         {if !$tsAction || $tsAction == 'posts'}
				<table class="linksList">
               <thead>
                	<tr>
                		<th>Post</th>
                		<th>Causa</th>
                     <th>Moderador</th>
                     <th>Acci&oacute;n</th>
                	</tr>
               </thead>
               <tbody>
                  {foreach from=$tsHistory item=h}
                  <tr>
                     <td>
                        {$h.post_title} <span class="d-block small">Por <a href="{$tsConfig.url}/perfil/{$h.user_name}">{$h.user_name}</a></span>
                     </td>
                     <td>{if $h.reason == 'undefined'}Indefinida{else}{$h.reason}{/if}</td>
                     <td>
                        <a href="{$tsConfig.url}/perfil/{$h.mod_name}">{$h.mod_name}</a>
                     </td>
                     <td>
                        {if $h.action == 1}<span class="text-success">Editado</span>{elseif $h.action == 2}<span class="text-danger">Eliminado</span>{else}<span style="color:purple;">Revisi&oacute;n</span>{/if}
                     </td>
                  </tr>
                  {/foreach}
               </tbody>
            </table>
			{elseif $tsAction == 'fotos'}
				<table class="linksList">
               <thead>
                  <tr>
                  	<th>Foto</th>
                     <th>Causa</th>
                  	<th>Moderador</th>
                     <th>Acci&oacute;n</th>
                  </tr>
               </thead>
               <tbody>
                  {foreach from=$tsHistory item=h}
                  <tr>
                     <td>
                        {$h.f_title} <span class="d-block small">Por <a href="{$tsConfig.url}/perfil/{$h.user_name}">{$h.user_name}</a></span>
                		</td>
                     <td>{if $h.reason == 'undefined'}Indefinida{else}{$h.reason}{/if}</td>
                     <td>
                        <a href="{$tsConfig.url}/perfil/{$h.mod_name}">{$h.mod_name}</a>
                     </td>
                     <td>
                        {if $h.action == 1}<span class="text-success">Editada</span>{else}<span class="text-danger">Eliminada</span>{/if}
                     </td>
                  </tr>
                  {/foreach}
               </tbody>
            </table>
			{/if}
      </div>
   </div>
</div>
{include file='sections/main_footer.tpl'}