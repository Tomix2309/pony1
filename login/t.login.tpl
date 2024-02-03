<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html data-bs-theme="dark" xmlns="http://www.w3.org/1999/xhtml" lang="{$Lang_short}" xml:lang="{$Lang_short}">
<head>
<title>{$tsTitle}</title>
{meta facebook=true twitter=true}
{jsdelivr type='styles' sources=['bootstrap','waitme','sweetalert2'] combine=true}
{hook 
	name="head" 
	lang="{$Lang}" 
	fonts=["Roboto"] 
	css=['SyntaxisLite.min.css', "{$tsPage}.css"] 
	js=['jquery.min.js'] 
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
		<div class="login_box bg-light-subtle shadow rounded overflow-hidden position-relative">
		   <div class="lader position-relative d-flex justify-content-center align-items-center saludo-{$tsLader}">
		      <h3>{$tsMessage}</h3>
		      <div class="position-absolute mx-auto bottom-5 right-3 left-0 w-25" style="display:none;" id="loading">
		         <div class="loading loading-lg success"></div>
		      </div>
		   </div>
		   <div class="offset-content">
		      <div class="login_cuerpo">
		         <div id="login_error" style="display:none;"></div>
		         <form id="loginForm" action="javascript:login.iniciarSesion()" method="post">
		            <div class="form-group">
		               <label class="form-label" for="nickname">Usuario</label>
		               <input class="form-control" type="text" id="nickname" name="nick" maxlength="64" placeholder="Nick">
		               <div class="help fst-italic"></div>
		            </div>
		            <div class="form-group">
		               <label class="form-label" for="password">Contraseña</label>
		               <input class="form-control" type="password" id="password" name="pass" maxlength="64" placeholder="Contraseña">
		               <div class="help fst-italic"></div>
		            </div>
		            <div class="form-check form-switch my-3">
						  	<input class="form-check-input" type="checkbox" name="rem" role="switch" id="rem" checked>
						  	<label class="form-check-label" for="rem">Recordar usuario</label>
						</div>
		            <input type="submit" value="Iniciar sesión" class="btn btn-login btn-primary mr-2">
		            <a href="{$tsConfig.url}/registro/" class="btn btn-success mr-2">Crear cuenta</a>
						{if $tsConfig.oauth}
						<span class="d-block text-center fs-5 my-4 text-uppercase">Continuar con...</span>
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
					<a class="badge bg-primary-subtle py-2 px-3 text-primary" href="javascript:login.remind_resend(false, 'password')">Recuperar contraseña</a>
					<a class="badge bg-primary-subtle py-2 px-3 text-primary" href="javascript:login.remind_resend(false, 'validation')">¡Activa tu cuenta!</a>
		      </div>
		   </div>
		</div>
	</div>
	
	<br>
{jsdelivr type='scripts' sources=['bootstrap','waitme','sweetalert2'] combine=true}
<script src="{$tsConfig.url}/{$tsPage}/{$tsPage}.js?{$smarty.now}"></script>
</body>
</html>