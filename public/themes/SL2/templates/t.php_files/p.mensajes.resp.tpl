1:
<li class="message-item resond">
   <a href="{$tsConfig.url}/perfil/{$tsUser->nick}" class="autor-image">
      <img alt="{$mp.user_name}" class="shadow" src="{$tsConfig.url}/files/avatar/{$tsUser->uid}.webp" />
   </a>
   <div class="content-message">
      <div class="d-flex justify-content-start align-items-center" style="margin-bottom:-6px;">
         <a href="{$tsConfig.url}/perfil/{$tsUser->nick}" class="text-capitalize text-white  fw-bolder">{$tsUser->nick}</a> 
         {if $tsUser->is_admod}<a class="d-inline-block text-white" href="{$tsConfig.url}/moderacion/buscador/1/1/{$mp.mr_ip}">{$mp.mp_ip}</a> {/if}
         <span class="small">{$mp.mp_date|hace:true}</span>
      </div><span class="px-2">{$mp.mp_body|nl2br}</span>                       
   </div>
</li>