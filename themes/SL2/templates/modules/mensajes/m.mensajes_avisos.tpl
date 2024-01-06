{if $tsMensajes}
<ul id="mpList">
   {foreach from=$tsMensajes item=av}
   <li id="av_{$av.av_id}" {if $av.av_read == 0} class="bg-light"{/if}>
      <table class="w-100" cellpadding="0" cellspacing="0">
         <tr>
            <td class="main_col">
               <a href="{$tsConfig.url}/mensajes/avisos/?aid={$av.av_id}">
                  <div class="mpContent clearBoth">
                     <i data-feather="{if $av.av_type == 0}info{elseif $av.av_type == 1}alert-triangle{elseif $av.av_type == 2}shield{elseif $av.av_type == 3}slash{else}gift{/if}"></i>
                     <div class="mp_desc">
                        <div class="mp_time">{$av.av_date|hace}</div>
                        <div class="autor"><strong>{$tsConfig.titulo}</strong></div>
                        <div class="small">{$av.av_subject}</div>
                        <div class="preview">{$av.av_body|truncate:70}</div>
                     </div>
                  </div>
               </a>
            </td>
            <td class="pls">
               <a href="{$tsConfig.url}/mensajes/avisos/?did={$av.av_id}" class="qtip" title="Eliminar"><i data-feather="x"></i></a>
            </td>
         </tr>
      </table>
   </li>
   {/foreach}
</ul>
{elseif $tsMensaje.av_id > 0}
<div class="mpRContent">
   <div class="bg-light p-2">
      <h2 class="m-0 p-0">{$tsMensaje.av_subject}</h2>
      <span class="d-flex justify-content-between align-items-center">
         <a href="{$tsConfig.url}" class="fw-bolder text-dark">{$tsConfig.titulo}</a> 
         <span class="floatR">{$tsMensaje.av_date|hace}</span>
      </span>
    </div>
    <ul class="mpHistory" id="historial">
      <li>
         <i data-feather="{if $tsMensaje.av_type == 0}info{elseif $tsMensaje.av_type == 1}alert-triangle{elseif $tsMensaje.av_type == 2}shield{elseif $tsMensaje.av_type == 3}slash{else}gift{/if}"></i>
         <div class="mensaje">
            <span>{$tsMensaje.av_body|nl2br}</span>
        </li>
    </ul>
</div>
<div class="clearBoth"></div>
{else}
   <div class="alert alert-warning text-center mx-2">{if $tsMensaje}{$tsMensaje}{else}No hay avisos o alertas{/if}</div>
{/if}
<style>
.mensaje span img {
  width: 100%;
}
</style>