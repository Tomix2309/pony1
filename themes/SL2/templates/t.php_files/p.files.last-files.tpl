{foreach from=$tsLastFiles.data item=a}
<div class="list_file" id="File_{$a.file_id}" {if $a.f_estado == 0}style="opacity: 0.5;" title="Este archivo est&aacute; desabilitado"{/if}>
   <a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}">
      <div class="File_format d-flex justify-content-center align-items-center">
         <svg class="icon"><use xlink:href="#{if $a.f_ext == 'csv' || $a.f_ext == 'html' || $a.f_ext == 'php'}other{else}{$a.f_ext}{/if}" /></svg>
      </div>
   </a>
   <div class="F_info position-relative">
      <a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}" class="d-block"><h2 class="m-0 p-1 text-dark h5" id="File_nombre">{$a.f_nombre|truncate:75}</h2></a>
      <small class="text-secondary d-block">{$a.f_fecha|hace} &bull; {$a.f_peso} &bull; Comentarios: {$a.f_comentarios} &bull; Subido por <a href="{$tsConfig.url}/perfil/{$a.user_name}" class="text-dark fw-bolder text-capitalize">{$a.user_name}</a></small>
    </div>
</div>
{/foreach}
{if $tsLastFiles.pages.pages > 0}
<div class="d-flex justify-content-center align-items-center">
	{if $tsLastFiles.pages.prev > 0 && $tsLastFiles.pages.max == false}
	   <a href="#" onclick="last_files('{$tsLastFiles.pages.prev}'); return false" class="btn btn-sm btn-primary">Anterior</a>
	{/if}
	{if $tsLastFiles.pages.next <= $tsLastFiles.pages.pages}
	   <a href="#" onclick="last_files('{$tsLastFiles.pages.next}'); return false" class="btn btn-sm btn-primary">Siguiente</a>
	{/if}
</div>
{/if}