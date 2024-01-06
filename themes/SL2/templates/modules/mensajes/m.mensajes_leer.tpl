<div class="mpRContent">
   <div class="bg-light p-2">
      <h2 class="m-0 p-0">{$tsMensajes.msg.mp_subject}</h2>
      <span class="d-block">Entre <a class="text-dark fw-bolder" href="{$tsConfig.url}/perfil/{$tsUser->nick}">T&uacute;</a> y <a class="text-dark fw-bolder" href="{$tsConfig.url}/perfil/{$tsMensajes.ext.user}">{$tsMensajes.ext.user}</a></span>
   </div>
   <ul class="messages" id="historial">
      {if $tsMensajes.res}
         {foreach from=$tsMensajes.res item=mp}
            <li class="message-item{if $mp.user_name == $tsUser->nick} resond{/if}">
               <a href="{$tsConfig.url}/perfil/{$mp.user_name}" class="autor-image">
                  <img alt="{$mp.user_name}" class="shadow" src="{$tsConfig.url}/files/avatar/{$mp.mr_from}.webp" />
               </a>
               <div class="content-message">
                  <div class="d-flex justify-content-start align-items-center" style="margin-bottom:-6px;">
                     <a href="{$tsConfig.url}/perfil/{$mp.user_name}" class="text-capitalize text-white  fw-bolder">{$mp.user_name}</a> 
                     {if $tsUser->is_admod}<a class="d-inline-block text-white" href="{$tsConfig.url}/moderacion/buscador/1/1/{$mp.mr_ip}">{$mp.mr_ip}</a> {/if}
                     <span class="small">{$mp.mr_date|hace}</span>
                  </div><span class="px-2">{$mp.mr_body|nl2br}</span>						
               </div>
            </li>
         {/foreach}
      {else}
         <li class="alert alert-warning text-center">No se pudieron cargar los mensajes.</li>
      {/if}
   </ul>
   {if $tsUser->is_admod || ($tsMensajes.msg.mp_del_to == 0 && $tsMensajes.msg.mp_del_from == 0 && $tsMensajes.ext.can_read == 1)}
      <div class="mpForm">
         <textarea id="respuesta" onfocus="onfocus_input(this)" onblur="onblur_input(this)" placeholder="Escribe una respuesta..." class="form-input w-100 onblur_effect"></textarea>
         <input type="hidden" style="" id="mp_id" value="{$tsMensajes.msg.mp_id}" />
         <a class="btn btn-success resp" onclick="mensaje.responder(); return false;">Responder</a>
      </div>
   {else}
      <div class="alert alert-info text-center">Un participante abandon&oacute; la conversaci&oacute;n o no tienes permiso para responder</div>
   {/if}
</div>