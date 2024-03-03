1:
<div id="RegistroForm">
	<!-- Paso Uno -->
	<div class="pasoUno">
		<div class="form-group position-relative">
			<label class="form-label" for="nick">Ingresa tu usuario</label>
			<input name="nick" type="text" class="form-input" id="nick" tabindex="1" title="Ingrese un nombre de usuario &uacute;nico" onfocus="registro.focus(this);this.removeAttribute('readonly');" readonly onblur="registro.blur(this)" onkeydown="registro.clear_time(this.name)" onkeyup="registro.set_time(this.name)" autocomplete="off" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-group position-relative">
			<label class="form-label" for="password">Contrase&ntilde;a deseada</label>
			<input name="password" type="password" class="form-input" id="password" tabindex="2" title="Ingresa una contrase&ntilde;a segura" onfocus="registro.focus(this);this.removeAttribute('readonly');" readonly onblur="registro.blur(this)" autocomplete="off" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-group position-relative">
			<label class="form-label" for="email">E-mail</label>

			<input name="email" type="text" class="form-input" id="email" tabindex="3" title="Ingresa tu direcci&oacute;n de email" onfocus="registro.focus(this)" onblur="registro.blur(this)" onkeydown="registro.clear_time(this.name)" onkeyup="registro.set_time(this.name)" autocomplete="off" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-group position-relative">
			<label class="form-label" for="sexo">Sexo</label>
			<select id="genero" class="form-select" name="sexo" tabindex="4" onblur="registro.blur(this)" onchange="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Selecciona tu g&eacute;nero">
            <option value="">Seleccionar g&eacute;nero</option>
            <option value="1" id="sexo_m">Masculino</option>
            <option value="0" id="sexo_f">Femenino</option>
         </select> 
			<div class="help"><span><em></em></span></div>
		</div>

		<div class="form-group position-relative">
         <input type="hidden" name="g-recaptcha-response" id="response" class="g-recaptcha">
         <div class="help"><span><em></em></span></div>
      </div>

		<div class="form-group position-relative">        
         <div class="checkbox">
            <input type="checkbox" id="terminos" name="terminos" value="true" tabindex="5" onblur="registro.blur(this)" onfocus="registro.focus(this)" title="Acepta los T&eacute;rminos y Condiciones?"/>
            <span class="checked"></span>
            <label for="terminos">Acepto los <a href="{$tsConfig.url}/pages/terminos-y-condiciones/" target="_blank">T&eacute;rminos de uso</a></label>
            <div class="help"><span><em></em></span></div>
         </div>
		</div>
	</div>
</div>
<script type="text/javascript">
registro.change_paso(1);
$('#loading').fadeOut(350);
var keyv3 = '{$tsKeyPbulic}';
// {literal}
grecaptcha.ready(function () {
   grecaptcha.execute(keyv3, {action: 'homepage'}).then(function (token) {
      var response = document.getElementById('response');
      response.value = token;
   });
});
// {/literal}
</script>