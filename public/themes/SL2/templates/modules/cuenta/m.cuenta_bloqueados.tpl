<div class="content-tabs bloqueados">
   <fieldset>
   <div class="field">
      {if $tsBlocks}
      <div class="row">
         {foreach from=$tsBlocks item=b}
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
               <div class="card-user">
                  <a href="{$tsConfig.url}/perfil/{$b.user_name}" class="usuario">
                     <img src="{$tsConfig.url}/files/avatar/{$b.b_auser}.webp" class="rounded shadow" alt="{$b.user_name}">
                     <span>{$b.user_name}</span>
                  </a>
                  <a title="Desbloquear Usuario" href="javascript:bloquear('{$b.b_auser}', false, 'mis_bloqueados')" class="btn btn-block btn-gradient-three bloquear_usuario_{$b.b_auser}">Desbloquear</a>
               </div>
            </div>
         {/foreach}
      </div>
      {else}
         <div class="alert alert-warning text-center fw-bolder">No hay usuarios bloqueados</div>
      {/if}
   </div>
   </fieldset>
</div>