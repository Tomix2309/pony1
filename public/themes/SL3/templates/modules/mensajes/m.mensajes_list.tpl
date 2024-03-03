{if $tsMensajes.data}
<ul id="mpList">
    {foreach from=$tsMensajes.data item=mp}
    <li id="mp_{$mp.mp_id}" class="mb-2{if $mp.mp_read_to == 0} bg-right{/if}">
      <div class="mpContent list-mps">
         <img src="{$tsConfig.url}/files/avatar/{$mp.mp_from}.webp" />
         <div class="mp_desc">
            <a href="{$tsConfig.url}/mensajes/leer/{$mp.mp_id}">
            <div class="mp_time">{$mp.mp_date|hace}</div>
            <div class="autor"><strong>{$mp.user_name}</strong></div>
            <div class="small">{$mp.mp_subject}</div>
            <div class="preview">{if $mp.mp_type == 1}<i data-feather="corner-up-left"></i>{/if}{$mp.mp_preview}</div></a>
         </div>
         <div class="plm">
            <a href="#" class="qtip read" title="Marcar como le&iacute;do" onclick="mensaje.marcar('{$mp.mp_id}:{$mp.mp_type}', 0, 1, this); return false;" {if $mp.mp_read_to == 1}style="display:none"{/if}><i data-feather="book-open"></i></a>
            <a href="#" class="qtip unread" title="Marcar como no le&iacute;do" onclick="mensaje.marcar('{$mp.mp_id}:{$mp.mp_type}', 1, 1, this); return false;" {if $mp.mp_read_to == 0}style="display:none"{/if}><i data-feather="book"></i></a>
         </div>
         <div class="pls">
            <a href="#" class="qtip" title="Eliminar" onclick="mensaje.eliminar('{$mp.mp_id}:{$mp.mp_type}',1); return false;"><i data-feather="x"></i></a>
         </div>
      </div>
   </li>
   {/foreach}
</ul>
{else}
<div class="alert alert-warning text-center mx-2">No hay mensajes</div>
{/if}
<div class="mpFooter">
    <div class="actions">{if $tsAction == ''}<strong>Ver: </strong> {if $tsQT == ''}<a href="{$tsConfig.url}/mensajes/?qt=unread">No le&iacute;dos</a>{else}<a href="{$tsConfig.url}/mensajes/">Todos los mensajes</a>{/if}{/if}</div>
    <div class="paginador">
        {if $tsMensajes.pages.prev != 0}<div style="text-align:left" class="floatL"><a href="{$tsConfig.url}/mensajes/{if $tsAction}{$tsAction}/{/if}?page={$tsMensajes.pages.prev}{if $tsQT != ''}&qt=unread{/if}">&laquo; Anterior</a></div>{/if}
        {if $tsMensajes.pages.next != 0}<div style="text-align:right" class="floatR"><a href="{$tsConfig.url}/mensajes/{if $tsAction}{$tsAction}/{/if}?page={$tsMensajes.pages.next}{if $tsQT != ''}&qt=unread{/if}">Siguiente &raquo;</a></div>{/if}
    </div>
    <div class="clearBoth"></div>
</div>