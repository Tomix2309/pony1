<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$Lang_short}" xml:lang="{$Lang_short}">
<head>
<title>{$tsTitle}</title>
{hook 
	name="head" 
	meta=false 
	lang="{$Lang}" 
	fonts=["Roboto"] 
	favicon="$tsImagen" 
	css=['SyntaxisLite.min.css', "{$tsPage}.css"] 
	js=['jquery.min.js', 'jquery.plugins.js', 'acciones.js'] 
}
<script>
var global_data = {
	user_key:'{$tsUser->uid}',
	img:'{$tsConfig.tema.t_url}/',
	url:'{$tsConfig.url}',
	domain:'{$tsConfig.domain}',
	s_title: '{$tsConfig.titulo}',
	s_slogan: '{$tsConfig.slogan}',
}; 
</script>
</head>
<body name="superior" id="body" class="py-3">
	<div id="mydialog" class="background__level--3" style="display:none"></div>
	
	<div class="backLogin background__level--3">
		<div class="login_box bg-white shadow rounded overflow-hidden position-relative">
			{if !$tsMobile}
		   <div class="lader position-relative d-flex justify-content-center align-items-center saludo-{$tsLader}">
		      <h3>{$tsMessage}</h3>
		      <div class="position-absolute mx-auto bottom-5 right-3 left-0 w-25" style="display:none;" id="loading">
		         <div class="loading loading-lg success"></div>
		      </div>
		   </div>
		   {/if}
		   <div class="offset-content">
		      <div class="login_cuerpo">
		         <div id="login_error" class="alert alert-danger position-absolute" style="display: none;"></div>
		         <form id="loginForm" action="javascript:login.iniciarSesion()" method="post">
		            <div class="form-group">
		               <label class="form-label" for="nickname">Usuario</label>
		               <input class="form-input" type="text" id="nickname" name="nick" maxlength="64" placeholder="Nick">
		               <div class="help fst-italic"></div>
		            </div>
		            <div class="form-group">
		               <label class="form-label" for="password">Contraseña</label>
		               <input class="form-input" type="password" id="password" name="pass" maxlength="64" placeholder="Contraseña">
		               <div class="help fst-italic"></div>
		            </div>
		            <div class="form-group">
		               <label class="form-checkbox cb-success" for="rem">
		                  <input type="checkbox" id="rem" name="rem" value="true" checked="checked">
		                  <i class="form-icon"></i> Recordar usuario
		               </label>
		            </div>
		            <input type="submit" value="Iniciar sesión" class="btn btn-login btn-gradient-three mr-2">
		            <a href="{$tsConfig.url}/registro/" class="btn btn-gradient-seven mr-2">Crear cuenta</a>
						{if $tsConfig.oauth}
						<span class="d-block mb-2 text-center fs-4">Continuar con...</span>
						<div class="btn-group-socials row" style="text-align: center;">
							{foreach $tsConfig.oauth key=i item=social}
								<div class="col-6">
									<a class="btn btn-social btn-{if $i == 'gmail'}google{else}{$i}{/if} btn-block mb-3" href="{$social}">
										<span><iconify-icon icon="fa6-brands:{if $i == 'gmail'}google{else}{$i}{/if}"></iconify-icon></span> {$i|ucfirst}
									</a>
								</div>
							{/foreach}
						</div>
						{/if}
		         </form>
		      </div>
		      <div class="d-flex justify-content-around align-items-center py-2">
		         <a class="text-info" href="javascript:remind_password()">&#191;Olvidaste tu contrase&#241;a?</a>
		      </div>
		   </div>
		</div>
	</div>
	
	<br>
{hook name="footer" cdns=["feather-icons"] js=['script.js']}
<script src="{$tsConfig.url}/{$tsPage}/{$tsPage}.js?{$smarty.now}"></script>
</body>
</html>