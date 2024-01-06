<div class="content-tabs perfil">
	<fieldset>
	   <div class="alert-cuenta cuenta-2"></div>
	   <div class="form-group">
	      <label class="form-label" for="nombre">Nombre completo</label>
	      <input type="text" value="{$tsPerfil.p_nombre}" maxlength="60" name="nombre" id="nombre" class="form-input cuenta-save-2">
	   </div>
	   <div class="form-group">
	      <label class="form-label" for="sitio">Mensaje Personal</label>
	      <textarea value="" maxlength="60" name="mensaje" id="mensaje" class="form-input cuenta-save-2">{$tsPerfil.p_mensaje}</textarea>
	   </div>
	   <div class="form-group">
	      <label class="form-label" for="sitio">Sitio Web</label>
	      <input type="text" value="{$tsPerfil.p_sitio}" maxlength="60" name="sitio" id="sitio" class="form-input cuenta-save-2">
	   </div>
   <div class="form-group">
      <label class="form-label" for="ft">Redes sociales</label>
      <div class="red-group">
         {foreach $tsRedes key=name item=red}
            <div class="red-item">
               <div class="icon"><i data-feather="{$red.icono}"></i></div>
               <input type="text" class="form-input" value="{$tsPerfil.p_socials.$name}" placeholder="{$red.nombre}" name="red[{$name}]">
            </div>
         {/foreach}
       </div>
   </div>
	   <div class="form-group">
	      <label class="form-label" for="estado">Estado Civil</label>
	      <select class="form-select cuenta-save-2" name="estado" id="estado">
	         {foreach from=$tsPData.estado key=val item=text}
	            <option value="{$val}" {if $tsPerfil.p_estado == $val}selected="selected"{/if}>{$text}</option>
	         {/foreach}
	      </select>
	   </div>
	   <div class="d-flex justify-content-center align-items-center">
	      <input type="button" value="Guardar y seguir" onclick="cuenta.guardar_datos()" class="btn btn-success">
	   </div>
	</fieldset>
</div>