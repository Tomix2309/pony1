<form name="new-folder">
	<div class="row row-cols-2">
		<div class="col">
			<div class="form-group">
				<label for="pass" class="col-form-label">Nombre de la carpeta</label>
				<input type="text" class="form-input" placeholder="Nombre de la carpeta..." name="car_name" size="55">
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label for="pass" class="col-form-label">Desea agregar contraseña</label>
				<input type="text" class="form-input" placeholder="Contraseña de la carpeta..." name="car_pass" size="55">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="pass" class="col-form-label">Tipo de carpeta</label>
		<select name="carpeta" class="form-select" id="carpeta">
			<option value="0" class="form-select option" id="carpeta-0" selected>Sin carpeta</option>
			{foreach $tsTypeOf key=id item=type}
				<option value="{$type.ct_id}" class="form-select option" id="carpeta-{$type.ct_id}"{if $type.ct_id == 6} selected{/if}>{$type.ct_name|ucfirst}</option>
			{/foreach}
		</select>
	</div>
	<div class="form-group">
		<label class="form-checkbox">Carpeta privada? <input type="checkbox" class="form-check-input" name="car_private"><span class="form-icon"></span> </label>
	</div>
</form>
<script>
$('input[name=car_pass]').on('keyup', () => {
	const texto = $('input[name=car_pass]').val();
	$('input[name=car_private]').parent().parent()[(!empty(texto) ? 'hide' : 'show')]()
})
$('input[name=car_private]').on('click', () => {
	let priv = $('input[name=car_private]').prop('checked')
	$('input[name=car_pass]').attr({
		disabled: priv
	})
})
</script>