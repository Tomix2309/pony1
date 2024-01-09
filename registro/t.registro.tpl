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
	<div class="wrapper container">
		<main class="shadow-4 overflow-hidden bg-white">
			<div class="cover">
				{image type="portada" src="{$tsConfig.files}/SyntaxisLite-ico.png"}
			</div>
			{if $tsConfig.c_reg_active === '1'}
				<div class="data">
					<form id="RegistroForm" action="javascript:registro.crearCuenta()" method="POST" autocomplete="OFF" class="d-flex justify-content-start align-items-start flex-column p-3 position-relative">
						<div class="mensajeAviso position-absolute w-100 h-100 zIndexFull">
							<span class="fw-bolder d-flex justify-content-center align-items-center w-100 h-100">Obteniendo código de reCAPTCHA...</span>
						</div>

						<h2 class="text-center py-1">Crea tu cuenta</h2>

						<div class="mb-3 chequear position-relative w-100">
							<label class="form-label" for="nick">Ingresa tu usuario*</label>
							<input name="nick" type="text" id="nick" tabindex="1" placeholder="Ingrese un nombre de usuario &uacute;nico" class="form-control" required /> 
							<div class="help fst-italic"></div>
							<div id="password-help-block" class="form-text">Puede contener {if $tsConfig.c_upperkey === '1'}<em>Mayúsculas</em>, {/if}<em>Minúsculas</em>, <em>Números</em></div>
						</div>

						<div class="mb-3 chequear position-relative w-100">
							<label class="form-label" for="password">Contrase&ntilde;a deseada*</label>
							<input name="password" type="text" id="password" tabindex="2" placeholder="Ingresa una contrase&ntilde;a segura" class="form-control" required /> 
							<div class="help fst-italic"></div>
							<div id="password-strength"><span></span> <em>Nivel</em></div>
						</div>

						<div class="mb-3 chequear position-relative w-100">
							<label class="form-label" for="email">E-mail*</label>
							<input name="email" type="text" id="email" tabindex="4" placeholder="Ingresa tu direcci&oacute;n de email" class="form-control" required /> 
							<div class="help fst-italic"></div>
						</div>

						<div class="mb-3 chequear position-relative w-100">
							<label class="form-label">Fecha de Nacimiento*</label>
							<input type="hidden" id="max" value="{$tsMaxY}">
							<input type="hidden" id="end" value="{$tsEndY}">
							<input name="nacimiento" type="date" id="nacimiento" tabindex="5" min="{$tsMaxY}-12-31" max="{$tsEndY}-12-31" class="form-control" required /> 
							<div class="help fst-italic"></div>
						</div>

						<div class="mb-3 chequear position-relative w-100">
						   <label class="form-label" for="sexo">G&eacute;nero</label>
						   <select id="genero" class="form-select" name="sexo" tabindex="6" title="Selecciona tu g&eacute;nero">
						     	<option value="">Seleccionar g&eacute;nero</option>
						      <option value="1" id="sexo_m">Masculino</option>
						      <option value="0" id="sexo_f">Femenino</option>
						   </select> 
						   <div class="help"><span><em></em></span></div>
						</div> 

						<div class="form-checkbox chequear">
							<input type="hidden" name="response" id="response" class="g-recaptcha">
				  			<input class="form-check-input" type="checkbox" id="terminos" tabindex="7" title="Acepta los T&eacute;rminos y Condiciones?" required>
				  			<div class="form-icon"></div>
				  			<label class="form-check-label" for="terminos">Acepto los <a href="{$tsConfig.url}/pages/terminos-y-condiciones/" target="_blank">T&eacute;rminos de uso</a>*</label>
						</div>
						<small>Todos los campos con * son requerido</small>
						<div class="py-3 d-flex justify-content-center align-items-center">
							<input type="submit" class="btn btn-primary" value="Crear cuenta">
						</div>
						{if $tsConfig.oauth}
						<span class="d-block mb-2 text-center fs-4">Continuar con...</span>
						<div class="btn-group-socials row w-100" style="text-align: center;">
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
			{else}
				<div class="d-flex justify-content-center align-items-center flex-column">
					<h1 class="fw-bolder">Bienvenido a {$tsConfig.titulo}!</h1>
					<p class="my-3">Temporalmente el registro de nuevas cuentas esta desactivado</p>
					<p>Pero, si ya tienes una cuenta, por favor <a class="text-success btn-login fw-bolder" href="{$tsConfig.url}/login/">inicia sesión</a></p>
				</div>
			{/if}
		</main>
	</div>
	<br>
{if $tsConfig.c_reg_active === '1'}
{jsdelivr type='scripts' sources=['feather-icons'] combine=false}
{hook name="footer" js=['script.js']}
<script>
	$(() => {
		const publicKey = '{$tsConfig.pkey}';

		function loadScript(url) {
		   return new Promise((resolve, reject) => $.getScript(url, resolve));
		}

		loadScript('https://www.google.com/recaptcha/api.js?render=' + publicKey)
	   .then(() => {
	     	grecaptcha.ready(() => {
	         grecaptcha.execute(publicKey, { action: 'submit' }).then(token => {
	            // Supongo que 'response' está definido en registro.js
	            response.value = token;
	            $(".mensajeAviso").hide()
					avanzar = true;
	         });
	     });
	   })
	   .then(() => loadScript('{$tsConfig.url}/{$tsPage}/registro.js'))
	   .catch(error => console.error('Error cargando scripts:', error));
	})
</script>
{/if}
</body>
</html>