<div class="boxy-title">
	<h3>Administrar Sesiones</h3>
</div>
<div id="res" class="boxy-content" style="position:relative">
{if !$tsAct}
	{if !$tsAdminSessions.data}
		<div class="hero hero-xl"><div class="hero-body">No hay usuarios o visitantes conectados</div></div>
	{else}
		<table class="table table-striped">
			<thead>
				<th>ID</th>
				<th>Usuario</th>
				<th>IP</th>
				<th>Fecha</th>
				<th>Auto login</th>
				<th>Acciones</th>
			</thead>
			<tbody>
				{foreach from=$tsAdminSessions.data item=s}
				<tr id="sesion_{$s.session_id}">
					<td>{$s.session_id}</td>
					<td align="left">{if $s.user_name}<a href="{$tsConfig.url}/perfil/{$s.user_name}" data-vcard="{$s.user_id}">{$s.user_name}</a>{else} Visitante{/if}</td>
					<td><a href="{$tsConfig.url}/moderacion/buscador/1/1/{$s.session_ip}" class="geoip" target="_blank">{$s.session_ip}</a></td>
					<td>{$s.session_time|hace:true}</td>
					<td>{if $s.session_autologin == 0}<font color="red">NO</font>{else}<font color="green">S&Iacute;</font>{/if}</td>
					<td class="admin_actions">
		            <a href="#" onclick="admin.sesiones.borrar('{$s.session_id}'); return false" title="Cerrar sesi&oacute;n de {if $s.user_name}{$s.user_name}{else}este visitante{/if}"><i data-feather="power"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
			<tfoot>
				<td colspan="7">P&aacute;ginas: {$tsAdminSessions.pages}</td>
			</tfoot>
		</table>
	{/if}
{/if}
</div>