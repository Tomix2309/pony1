<div class="content-tabs privacidad">
   <fieldset>
      <div class="alert-cuenta cuenta-4"></div>
      
      <h2 class="active">&iquest;Qui&eacute;n puede...</h2>
      <div class="form-group">
         <label class="form-label">ver tu muro?</label>
         <select name="muro" class="cuenta-save-4 form-select">
            {foreach from=$tsPrivacidad item=p key=i}
               <option value="{$i}"{if $tsPerfil.p_configs.m == $i} selected="true"{/if}>{$p}</option>
            {/foreach}
         </select>
      </div>
                                    
		{$tsPerfil.p_configs.muro}
                                    
		<div class="form-group">
         <label class="form-label">firmar tu muro?</label>
         <select name="muro_firm" class="cuenta-save-4 form-select">
            {foreach from=$tsPrivacidad item=p key=i}
               {if $i != 6}
               	<option value="{$i}"{if $tsPerfil.p_configs.mf == $i}selected{/if}>{$p}</option>
               {/if}
            {/foreach}
         </select>
      </div>
		<div class="form-group">
         <label class="form-label">ver &uacute;ltimas visitas?</label>
         <select name="last_hits" class="cuenta-save-4 form-select">
            {foreach from=$tsPrivacidad item=p key=i}
               {if $i != 1 && $i != 2}
               	<option value="{$i}"{if $tsPerfil.p_configs.hits == $i}selected{/if}>{$p}</option>
               {/if}
            {/foreach}
         </select>
      </div>
		{if !$tsUser->is_admod}
			{if $tsPerfil.p_configs.rmp != 8}
				<div class="form-group">
               <label class="form-label">enviarte MPs?</label>
               <select name="rec_mps" class="cuenta-save-4 form-select">
                  {foreach from=$tsPrivacidad item=p key=i}
                     {if $i != 6}
                     	<option value="{$i}"{if $tsPerfil.p_configs.rmp == $i}selected{/if}>{$p}</option>
                     {/if}
                  {/foreach}
               </select>
            </div>
			{else}
				<div class="alert alert-danger">Algunas opciones de su privacidad han sido deshabilitadas, contacte con la administraci&oacute;n.</div>
			{/if}
		{/if}
   </fieldset>
   <div class="d-flex justify-content-center align-items-center">
   	{if !$tsUser->is_admod}
			<a onclick="desactivate(0); return false;" class="btn btn-danger">Desactivar Cuenta</a>
		{/if}
      <input type="button" value="Guardar" onclick="cuenta.save(4)" class="btn btn-success">
   </div>
</div>