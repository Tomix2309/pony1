{if $tsResult.data}
<div class="box-lateral">
   <div class="box-header h4"><span>Resultados de la busqueda para "<b>{$tsResult.text}</b>"</span> <span id="Files_total">{$tsResult.total}</span></div>
   <div class="box-body">
      <div class="F_files">
         {foreach from=$tsResult.data item=a}
            <div class="list_file" id="File_{$a.file_id}">
               <a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}">
                  <div class="File_format d-flex justify-content-center align-items-center">
                     <svg class="icon"><use xlink:href="#{if $a.f_ext == 'csv'}other{else}{$a.f_ext}{/if}" /></svg>
                  </div>
               </a>
               <div class="F_info position-relative">
                  <a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}" class="d-block"><h2 class="m-0 p-1 text-dark h5" id="File_nombre">{$a.f_nombre|truncate:75}</h2></a>
                  <small class="text-secondary d-block"><input type="checkbox" name="file_id_box[]" value="{$a.file_id}" onclick="check.marcar();" /> {if $a.f_privado == 1}Privado{else}P&uacute;blico{/if} - {$a.f_fecha|hace} &bull; {$a.f_peso} &bull; Descargas: {$a.f_descargas} &bull; {$a.f_ext} &bull; Por <a href="{$tsConfig.url}/perfil/{$a.user_name}" class="text-dark fw-bolder text-capitalize">{$a.user_name}</a></small>
                  {if $tsUser->uid == $filesUser.user_id || $tsUser->is_admod}
                     <div class="opciones">
                        <i data-feather="sliders"></i>
                        <div class="opcf rounded shadow">
                           <a href="#" onclick="download_file({$a.file_id}); return false;" class="d-block px-2 text-success">Descargar</a>
                           <a href="#" onclick="borrar_file({$a.file_id}, false); return false;" class="d-block px-2 text-danger">Borrar</a>
                           {if $filesUser.user_id == $tsUser->uid}
                              <a href="#" onclick="folder.cargar({$a.file_id}); return false;" class="d-block px-2 text-warning">Mover</a>
                           {/if}
                           <a href="#" onclick="editar_nombre({$a.file_id}, '{$a.f_nombre}', false); return false;" class="d-block px-2 text-primary">Editar nombre</a>
                           <a href="#" class="px-2 text-danger File_privado_b{$a.file_id}" {if $a.f_privado == 1}style="display: none;"{/if} onclick="file_private({$a.file_id}, 1); return false;" title="Cambiar a privado">Cambiar a Privado</a>
                           <a href="#" class="px-2 text-success File_privado_b{$a.file_id}" {if $a.f_privado == 0}style="display: none;"{/if} onclick="file_private({$a.file_id}, 0); return false;" title="Cambiar a p&uacute;blico">Cambiar a P&uacute;blico</a>
                        </div>
                     </div>
                  {/if}
               </div>
            </div>
         {/foreach}
      </div>
   </div>    
</div>
{else}
   <div class="alert alert-warning text-center">No se encontraron resultados para "{$tsResult.text}" en esta ubicaci&oacute;n</div>
{/if}
<script>
   feather.replace({ class: 'featherIcons', 'stroke-width': 1})
</script>