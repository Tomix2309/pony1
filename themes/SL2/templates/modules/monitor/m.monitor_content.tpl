<div id="centroDerecha">
   <h2>&Uacute;ltimas {$tsData.total} notificaciones</h2>
   {if $tsData.data}
      <ul class="notification-detail list-unstyled">
      {foreach from=$tsData.data item=noti}
         <li class="position-relative{if $noti.unread > 0} bg-light{/if}">
         	<div class="avatar-box">
             	<a href="{$tsConfig.url}/perfil/{$noti.user}">
             		<img class="rounded" src="{$tsConfig.url}/files/avatar/{$noti.avatar}"/>
               </a>
            </div>
            <div class="notification-info">
             	<span class="d-block">
                  {if $noti.total == 1}<a href="{$tsConfig.url}/perfil/{$noti.user}" class="text-dark fw-bolder">{$noti.user}</a>{/if} {$noti.text} <a href="{$noti.link}" class="text-dark fw-bolder">{$noti.ltext}</a>
                  <span title="{$noti.date|hace}" class="small d-block text-muted">{$noti.date|hace}</span>
               </span>
            </div>
            <span class="monac_icons ma_{$noti.style}"></span>
         </li>
      {/foreach}
      </ul>
   {else}
      <div class="alert alert-warning text-center">No tienes notificaciones</div>
   {/if}
</div>