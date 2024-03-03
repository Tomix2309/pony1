<div class="boxy-title">
	<h3>Administrar Usuarios</h3>
</div>
<div id="res" class="boxy-content" style="position:relative">
{if !$tsAct}
	{if !$tsMembers.data}
		<div class="hero hero-xl"><div class="hero-body">No hay usuarios registrados.</div></div>
	{else}
		<table class="table table-striped">
			<thead>
				<th>Rango</th>
				<th>Usuario</th>
				<th><a title="Ordenar por email ascendente" href="{$tsConfig.url}/admin/users?o=c&m=a"><</a> Email <a title="Ordenar por email descendente" href="{$tsConfig.url}/admin/users?o=c&m=d">></a></th>
				<th><a title="Ordenar por &uacute;ltima vez activo ascendente" href="{$tsConfig.url}/admin/users?o=u&m=a"><</a> &Uacute;ltima actividad <a title="Ordenar por &uacute;ltima vez activo desccendente" href="{$tsConfig.url}/admin/users?o=u&m=d">></a></th>
				<th>Registro</th>
				<th><a title="Ordenar por IP ascendente" href="{$tsConfig.url}/admin/users?o=i&m=a"><</a> IP <a title="Ordenar por IP descendente" href="{$tsConfig.url}/admin/users?o=i&m=d">></a> </th>
				<th><a title="Ordenar por estado ascendente" href="{$tsConfig.url}/admin/users?o=e&m=a"><</a> Estado <a title="Ordenar por estado descendente" href="{$tsConfig.url}/admin/users?o=e&m=d">></a></th>
				<th>Acciones</th>
			</thead>
			<tbody>
				{foreach from=$tsMembers.data item=m}
				<tr>
					<td><img src="{$tsConfig.images}/icons/ran/{$m.r_image}" /></td>
					<td align="left"><a href="{$tsConfig.url}/perfil/{$m.user_name}" data-vcard="{$m.user_id}" style="color:#{$m.r_color};">{$m.user_name}</a></td>
					<td>{$m.user_email}</td>
					<td>{if $m.user_lastactive == 0} Nunca{else}{$m.user_lastactive|hace:true}{/if}</td>
					<td>{$m.user_registro|date_format:"%d/%m/%Y"}</td>
					<td><a href="{$tsConfig.url}/moderacion/buscador/1/1/{$m.user_last_ip}" class="geoip" target="_blank">{$m.user_last_ip}</a></td>
					<td id="status_user_{$m.user_id}">{if $m.user_baneado == 1}<font color="red">Suspendido</font>{elseif $m.user_activo == 0}<font color="purple">Inactivo</font>{else}<font color="green">Activo</font>{/if}</td>
					<td class="admin_actions">
						<a href="{$tsConfig.url}/admin/users?act=show&uid={$m.user_id}" title="Editar Usuario"><i data-feather="edit-3"></i></a>												
						<a onclick="admin.users.setInActive({$m.user_id}); return false;" title="Activar/Desactivar Usuario"><i data-feather="refresh-ccw"></i></a>
		            <a href="#" onclick="mod.users.action({$m.user_id}, 'aviso', false); return false;" title="Enviar Alerta"><i data-feather="alert-triangle"></i></a>
						<a href="#" onclick="mod.{if $m.user_baneado == 1}reboot({$m.user_id}, 'users', 'unban', false){else}users.action({$m.user_id}, 'ban', false){/if}; return false;" title="{if $m.user_baneado == 1}Reactivar{else}Suspender{/if} Usuario"><i data-feather="{if $m.user_baneado == 1}user-check{else}alert-octagon{/if}"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
			<tfoot>
				<td colspan="8">P&aacute;ginas: {$tsMembers.pages}</td>
			</tfoot>
		</table>
	{/if}
{elseif $tsAct == 'show'}
	<div class="d-flex justify-content-around align-items-center">
		<a href="{$tsConfig.url}/admin/users?act=show&uid={$tsUserID}&t=1" class="btn btn-{if $tsType == 1 || $tsType == ''}primary{else}light{/if}">Vista general</a>
		<a href="{$tsConfig.url}/admin/users?act=show&uid={$tsUserID}&t=5" class="btn btn-{if $tsType == 5}primary{else}light{/if}">Preferencias</a>
		<a href="{$tsConfig.url}/admin/users?act=show&uid={$tsUserID}&t=6" class="btn btn-{if $tsType == 6}primary{else}light{/if}">Borrar Contenido</a>
		<a href="{$tsConfig.url}/admin/users?act=show&uid={$tsUserID}&t=7" class="btn btn-{if $tsType == 7}primary{else}light{/if}">Rango</a>
		<a href="{$tsConfig.url}/admin/users?act=show&uid={$tsUserID}&t=8" class="btn btn-{if $tsType == 8}primary{else}light{/if}">Firma</a>
	</div>
	{if $tsSave}<div class="alert alert-info">Tus cambios han sido guardados.</div>{/if}
	{if $tsError}<div class="alert alert-danger">{$tsError}</div>{/if}
	<form action="" method="post">
		<fieldset>
		{if !$tsType || $tsType == 1}
			<legend>Vista general</legend>
			<dl>
				<dt><label for="user">Nombre de Usuario:</label></dt>
				<dd><input type="text" name="nick" class="form-input" id="user" value="{$tsUserD.user_name}" title="El nick s&oacute;lo se cambiar&aacute; si escribe una nueva contrase&ntilde;a" /></dd>
			</dl>
			<dl>
				<dt><label for="user">Rango:</label></dt>
				<dd><strong style="color:#{$tsUserD.r_color}">{$tsUserD.r_name}</strong></dd>
			</dl>
			<dl>
				<dt><label for="registro">Registrado:</label></dt>
				<dd><strong>{$tsUserD.user_registro|date_format:"%d/%m/%Y a las %H:%M"}</strong></dd>
			</dl>
			<dl>
				<dt><label>&Uacute;ltima vez activo:</label></dt>
				<dd><strong>{$tsUserD.user_lastactive|hace}</strong></dd>
			</dl>
			<dl>
				<dt><label>Puntos:</label></dt>
				<dd><input type="text" name="points" id="points" value="{$tsUserD.user_puntos}" style="width:10%" /></dd>
			</dl>
			<dl>
				<dt><label>Puntos para dar:</label></dt>
				<dd><input type="text" name="pointsxdar" id="pointsxdar" value="{$tsUserD.user_puntosxdar}" style="width:10%" /></dd>
			</dl>
			<dl>
				<dt><label>Cambios de nick disponibles:</label></dt>
				<dd><input type="text" name="changenicks" id="changenicks" value="{$tsUserD.user_name_changes}" style="width:10%" /></dd>
			</dl>
			<hr />
			<dl>
				<dt><label for="email">E-mail:</label></dt>
				<dd><input type="text" name="email" id="email" value="{$tsUserD.user_email}" /></dd>
			</dl>
			<dl>
				<dt><label for="pwd">Nueva contrase&ntilde;a:</label><br /><span>Debe tener entre 5 y 35 caracteres.</span></dt>
				<dd><input type="password" name="pwd" class="form-input" id="pwd" onkeypress="if($('#cpwd').val() != '') $('#sendata').fadeIn();"/></dd>
			</dl>
			<dl>
				<dt><label for="cpwd">Confirmar contrase&ntilde;a:</label><br /><span>Necesita confirmar su contrase&ntilde;a s&oacute;lo si la ha cambiado arriba.</span></dt>
				<dd><input type="password" name="cpwd" class="form-input" id="cpwd" onkeypress="if($('#pwd').val() != '') $('#sendata').fadeIn();"/></dd>
			</dl>
			 <dl id="sendata" style="display:none;">
				<dt><label for="sendata">Informar al usuario</label><br /><span>Marque esta casilla si quiere enviar un e-mail al usuario con los nuevos datos</span></dt>
				<dd><input type="checkbox" name="sendata"/></dd>
			</dl>
		{elseif $tsType == 5}
			<legend>Modificar privacidad del usuario</legend>
			<h2 class="active">&iquest;Qui&eacute;n puede...</h2>
			<div class="field">
				<dl>
					<dt><label>ver su muro?</label></dt>
					<dd>
						<select name="muro" style="width:270px;">
						{foreach from=$tsPrivacidad item=p key=i}
						<option value="{$i}"{if $tsPerfil.p_configs.m == $i} selected="true"{/if}>{$p}</option>
						{/foreach}
						</select>
					</dd>
				</dl>                    				
			</div>
			{$tsPerfil.p_configs.muro}
			<div class="field">
				<dl>
				<dt><label>firmar su muro?</label></dt>
					<dd>
						<select name="muro_firm" style="width:270px;">
						{foreach from=$tsPrivacidad item=p key=i}
						{if $i != 6}<option value="{$i}"{if $tsPerfil.p_configs.mf == $i}selected{/if}>{$p}</option>{/if}
						{/foreach}
						</select>
					</dd>
				</dl>
			</div>
			<div class="field">
				<dl>
				<dt><label>ver visitantes recientes?</label></dt>
					<dd>
						<select name="last_hits" style="width:270px;">
						{foreach from=$tsPrivacidad item=p key=i}
						{if $i != 1 && $i != 2}<option value="{$i}"{if $tsPerfil.p_configs.hits == $i}selected{/if}>{$p}</option>{/if}
						{/foreach}
						</select>
					</dd>
				</dl>
			</div>
			<div class="field">
				<dl>
					<dt><label>enviarles mensajes privados?</label><br /><span>Esta opci&oacute;n no se aplica a moderadores y administradores.</span></dt>
					<dd>
						<select name="rec_mps" style="width:270px;">
							{foreach from=$tsPrivacidad item=p key=i}
								{if $i != 6}<option value="{$i}"{if $tsPerfil.p_configs.rmp == $i}selected{/if}>{$p}</option>{/if}
							{/foreach}
							<option value="8"{if $tsPerfil.p_configs.rmp == 8}selected{/if}>Deshabilitar mensajer&iacute;a (opci&oacute;n administrativa)</option>
						</select>
					</dd>
				</dl>
			</div>
	   {elseif $tsType == 6}
			<legend>Eliminaci&oacute;n de contenidos</legend>
			<input type="checkbox" id="bocuenta" name="bocuenta" onclick="$('#ext').slideToggle();" class="float-start mt-3 me-2" /><label class="fw-bolder" for="bocuenta">Cuenta Completa <small class="d-block">Se eliminar&aacute; la cuenta y todo el contenido relacionado a {$tsUsername}.</small></label>
			<div id="ext">
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="boposts" name="boposts" class="me-2" /><label class="fw-bolder" for="boposts">Posts <small class="d-block">Se eliminar&aacute;n todos sus posts y sus comentarios.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bocomposts" name="bocomposts" class="me-2" /><label class="fw-bolder" for="bocomposts">Comentarios de Posts <small class="d-block">Se eliminar&aacute;n todos sus comentarios en posts.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bofotos" name="bofotos" class="me-2" /><label class="fw-bolder" for="bofotos">Fotos <small class="d-block">Se eliminar&aacute;n todas sus fotos publicadas y sus comentarios.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bocomfotos" name="bocomfotos" class="me-2" /><label class="fw-bolder" for="bocomfotos">Comentarios de Fotos <small class="d-block">Se eliminar&aacute;n todos sus comentarios en fotos.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bofiles" name="bofiles" class="me-2" /><label class="fw-bolder" for="bofiles">Archivos <small class="d-block">Se eliminar&aacute;n todas sus archivos publicadas y sus comentarios.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bocomfiles" name="bocomfiles" class="me-2" /><label class="fw-bolder" for="bocomfiles">Comentarios de Archivos <small class="d-block">Se eliminar&aacute;n todos sus comentarios en archivos.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="boestados" name="boestados" class="me-2" /><label class="fw-bolder" for="boestados">Estados <small class="d-block">Se eliminar&aacute;n todas sus publicaciones de muros</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bocomestados" name="bocomestados" class="me-2" /><label class="fw-bolder" for="bocomestados">Comentarios en Estados <small class="d-block">Se eliminar&aacute;n todos sus comentarios en estados</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bolike" name="bolike" class="me-2" /><label class="fw-bolder" for="bolike">Like <small class="d-block">Se eliminar&aacute;n sus likes en estados y comentarios en estados</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="boseguidores" name="boseguidores" class="me-2" /><label class="fw-bolder" for="boseguidores">Seguidores <small class="d-block">Se eliminar&aacute; la lista de todos sus seguidores.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bosiguiendo" name="bosiguiendo" class="me-2" /><label class="fw-bolder" for="bosiguiendo">Siguiendo <small class="d-block">Se eliminar&aacute; la lista de todos a los que sigue.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bofavoritos" name="bofavoritos" class="me-2" /><label class="fw-bolder" for="bofavoritos">Favoritos <small class="d-block">Se eliminar&aacute; la lista de favoritos que haya agregado.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bovotosposts" name="bovotosposts" class="me-2" /><label class="fw-bolder" for="bovotosposts">Votos en Posts <small class="d-block">Se eliminar&aacute;n los votos de puntos que haya dejado en posts.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bovotosfotos" name="bovotosfotos" class="me-2" /><label class="fw-bolder" for="bovotosfotos">Votos en Fotos <small class="d-block">Se eliminar&aacute;n los votos positivos y negativos que haya dejado en fotos.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="boactividad" name="boactividad" class="me-2" /><label class="fw-bolder" for="boactividad">Actividad <small class="d-block">Se eliminar&aacute; toda su actividad.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="boavisos" name="boavisos" class="me-2" /><label class="fw-bolder" for="boavisos">Avisos <small class="d-block">Se eliminar&aacute;n todos los avisos que ha recibido.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bobloqueos" name="bobloqueos" class="me-2" /><label class="fw-bolder" for="bobloqueos">Bloqueos <small class="d-block">Se eliminar&aacute;n todos los bloqueos que ha recibido.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bomensajes" name="bomensajes" class="me-2" /><label class="fw-bolder" for="bomensajes">Mensajes Privados <small class="d-block">Se eliminar&aacute;n todos los mensajes que ha enviado y recibido.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bosesiones" name="bosesiones" class="me-2" /><label class="fw-bolder" for="bosesiones">Sesiones <small class="d-block">Se eliminar&aacute;n todas las sesiones.</small></label>
	           <hr style="margin:3px 0">
	           <input type="checkbox" class="float-start mt-3 me-2" id="bovisitas" name="bovisitas" class="me-2" /><label class="fw-bolder" for="boavisos">Visitas <small class="d-block">Se eliminar&aacute;n todo rastro de visitas de este usuario en perfiles, posts y fotos.</small></label>
			</div>
			<hr/>
			Introduzca su contrase&ntilde;a para continuar: <input type="password" class="form-input" name="password"/>
		{elseif $tsType == 7}
			<legend>Modificar rango de usuario</legend>
			<dl>
				<dt><label>Rango actual:</label></dt>
				<dd><strong style="color:#{$tsUserR.user.r_color}">{$tsUserR.user.r_name}</strong></dd>
			</dl>
			<dl>
				<dt><label for="user">Nuevo rango:</label></dt>
				<dd>
					<select name="new_rango">
						{foreach from=$tsUserR.rangos item=r}
							<option value="{$r.rango_id}" style="color:#{$r.r_color}" {if $r.rango_id == $tsUserR.user.rango_id}selected="selected"{/if}>{$r.r_name}</option>
						{/foreach}
					</select>
				</dd>
			</dl>
		{elseif $tsType == 8}
			<legend>Modificar firma de usuario</legend>
			<textarea name="firma" class="form-input" rows="3" cols="50">{$tsUserF.user_firma}</textarea>
		{else}
			<div class="phpostAlfa">Pendiente</div>
		{/if}
		<p><input type="submit" name="save" value="Enviar Cambios" class="btn btn-success"/></p>
		</fieldset>
	</form>
{/if}
</div>