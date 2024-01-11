1:
<div id="perfil_sesion" class="widget" status="activo">
	<div class="title-w clearfix">
      <h2>Mis sesiones</h2>
   </div>
   <ul class="listado">
   	
	   <li class="clearfix">
		 	<label class="form-label">Dispositivo</label>
		 	<span onclick="dispositivo('{$tsSesion.navegador}');return false;" class="d-flex justify-content-start align-items-center"><i data-feather="{$tsSesion.tipo}" class="me-2"></i> {$tsSesion.system}</span>
		</li>
		<li class="clearfix">
	   	<label class="form-label">Usuario del dispositivo</label>
	   	<span>{$tsSesion.usuario}</span>
	   </li>
	   <li class="clearfix d-none">
	   	<label class="form-label">Clave de seguridad</label>
	   	<span>{$tsSesion.clave}</span>
	   </li>
	   <li class="clearfix">
	   	<label class="form-label">Inicio sesión</label>
	   	<span>{$tsSesion.actividad|hace}</span>
	   </li>
	   <li class="clearfix">
	   	<label class="form-label">Creo su cuenta</label>
	   	<span>{$tsSesion.registro|hace}</span>
	   </li>
	   <li class="clearfix">
	   	<label class="form-label">IP</label>
	   	<span>{$tsSesion.ip}</span>
	   </li>
	</ul>
</div>
<script>
   feather.replace({ class: 'featherIcons', 'stroke-width': 1})
</script>
