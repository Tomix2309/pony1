1:
<div class="lista_carpeta" id="folderid_{$folder.1}">
   <a class="d-flex justify-content-center align-items-center text-center" href="{$tsConfig.url}/files/{$filesUser.user_name}/{$folder.1}/{$folder.2}"><i data-feather="folder"></i></a>
   <div class="F_info position-relative d-flex justify-content-center align-items-start flex-column">
      <a href="{$tsConfig.url}/files/{$filesUser.user_name}/{$folder.1}/{$folder.2}" class="d-block" id="Folder_name">{$folder.0}</a>
      <span class="small"><span id="Folder_privado_{$folder.1}">Privada</span> - Hace unos segundos</span>
      <div class="opciones">
         <i data-feather="sliders"></i>
         <div class="opcf rounded shadow">
            <a href="#" onclick="borrar_folder({$folder.1}); return false;" class="d-block text-danger">Borrar</a>
            <a href="#" onclick="editar_folder({$folder.1}, '{$folder.0}'); return false;" class="d-block text-info">Editar nombre</a>
            <a href="#" class="text-danger Folder_privado_{$folder.1}" {if $f.folder_priv == 1}style="display: none;"{/if} onclick="folder_private({$folder.1}, 1); return false;" title="Cambiar a privada">Cambiar a Privada</a>
            <a href="#" class="text-success Folder_privado_{$folder.1}" {if $f.folder_priv == 0}style="display: none;"{/if} onclick="folder_private({$folder.1}, 0); return false;" title="Cambiar a p&uacute;blica">Cambiar a P&uacute;blica</a>
         </div>
      </div>
   </div>
</div>
<script>
   feather.replace({ class: 'featherIcons', 'stroke-width': 1})
</script>