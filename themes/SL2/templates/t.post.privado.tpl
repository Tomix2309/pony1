{include file='sections/main_header.tpl'}

<div class="post-deleted post-privado clearbeta">
	<div class="content-splash">
		<h3>...O identif&iacute;cate</h3>
		<div class="login_cuerpo">
         <span class="gif_cargando floatR" id="login_cargando" style="display: none;"></span>
        	<div id="login_error" class="alert alert-danger position-absolute" style="display: none;"></div>
			<form action="javascript:login_ajax()" method="post">
				<input type="hidden" value="/registro" name="redirect">
				<div class="form-group">
					<label class="form-label">Usuario</label>
					<input type="text" tabindex="20" class="form-input" id="nickname" name="nick" maxlength="64"/>
				</div>
				<div class="form-group">
					<label class="form-label">Contrase&ntilde;a</label>
					<input type="password" tabindex="21" class="form-input" id="password" name="pass" maxlength="64"/>
				</div>
            <div class="form-group">
               <label class="form-checkbox cb-success" for="rem">
                  <input type="checkbox" id="rem" name="rem" value="true" checked="checked">
                  <i class="form-icon"></i> Recordarme?
               </label>
            </div>
				<input type="submit" value="Iniciar sesión" class="btn btn-login btn-gradient-three mr-4">	
			</form>
         <div class="d-flex justify-content-around align-items-center py-2">
				<a tabindex="23" href="javascript:remind_password()" class="text-dark fw-bolder">&iquest;Olvidaste tu contrase&ntilde;a?</a> 
				<a tabindex="23" href="javascript:resend_validation()" class="text-dark fw-bolder">&iquest;Quieres activar tu cuenta?</a>
			</div>
		</div>
	</div>
	<div class="latr back-{if $tsType == 'post'}{else}safe{/if}">
		{if $tsType == 'post'}
			<h3>Este post es privado, s&oacute;lo los usuarios registrados de {$tsConfig.titulo} pueden acceder.</h3>
			<p>Pero no te preocupes, tambi&eacute;n puedes formar parte de nuestra gran familia. <a title="Reg&iacute;strate!" href="{$tsConfig.url}/registro/">Reg&iacute;strate!</a></p>
		{else}
			<h3>Registrate en {$tsConfig.titulo}</h3>
			<strong>&iexcl;Atenci&oacute;n!</strong>
			<p>Antes de ingresar tus datos asegurate que la URL de esta p&aacute;gina pertenece a {$tsConfig.titulo}</p>
			<small class="d-block">{$tsConfig.url}</small>
		{/if}
	</div>
</div>
{include file='sections/main_footer.tpl'}