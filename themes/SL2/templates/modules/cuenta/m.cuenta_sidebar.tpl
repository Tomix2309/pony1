<div class="box-lateral">
   <div class="box-header">Avatar 
      <a class="float-end" id="cambiar" href="{$tsConfig.url}/cuenta/avatar"><i data-feather="refresh-cw"></i></a>
   </div>
   <div class="box-body">
      <div class="avatar-big-cont shadow rounded">
         <div style="display: none" class="avatar-loading"></div>
         <img alt="Avatar" src="{$tsPerfil.avatar}" class="avatar-big" id="avatar-img"/>
      </div>
   </div>
   <a class="btn btn-block m-3 d-block btn-info" id="cambiar" href="{$tsConfig.url}/cuenta/avatar">Cambiar avatar</a>
   <br>
</div>
<div id="prueba"></div>
   <div class="btn-group-socials">
      {foreach $tsConfig.oauth key=i item=social}
         {if $tsPerfil.socials.$i}
            <a href="javascript:desvincular('{$i}')" class="btn-social btn-active btn-{$i}">Desvincular {$i}</a>
         {else}
            <a class="btn-social btn-active btn-{$i}" href="{$social}">Vincular {$i}</a>
         {/if}
      {/foreach}
   </div>