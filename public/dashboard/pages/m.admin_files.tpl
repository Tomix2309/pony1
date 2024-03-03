<div class="boxy-title">
	<h3>Administrar Archivos</h3>
</div>
<div id="res" class="boxy-content" style="position:relative">
	{if $tsAct == ''}
		{if !$tsAdminFiles.data}
			<div class="hero hero-xl"><div class="hero-body">No hay archivos.</div></div>
		{else}
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th><a title="Ordenar por nombre ascendente" href="{$tsConfig.url}/admin/files?o=n&m=a"><</a> T&iacute;tulo <a title="Ordenar por nombre descendente" href="{$tsConfig.url}/admin/files?o=n&m=d">></a></th>
					<th><a title="Ordenar por extension ascendente" href="{$tsConfig.url}/admin/files?o=e&m=a"><</a> Extensión <a title="Ordenar por extension descendente" href="{$tsConfig.url}/admin/files?o=e&m=d">></a></th>
					<th>Fecha</th>
					<th><a title="Ordenar por IP ascendente" href="{$tsConfig.url}/admin/files?o=ip&m=a"><</a> IP <a title="Ordenar por IP descendente" href="{$tsConfig.url}/admin/files?o=ip&m=d">></a></th>
					<th>Acciones</th>
				</thead>
				<tbody>
				{foreach from=$tsAdminFiles.data item=a}
					<tr id="file_{$a.file_id}">
						<td>{$a.file_id}</td>
						<td><a class="text-dark" href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}" target="_blank">{$a.f_nombre|truncate:40}</a><small class="d-block">{if $a.f_privado == 1}<font color="red">Privado</font>{else}<font color="green">Publico</font>{/if} - <a href="{$tsConfig.url}/perfil/{$a.user_name}" data-vcard="{$a.user_id}">{$a.user_name}</a></small></td>
						<td class="fw-bolder text-capitalize">{$a.f_ext}</td>
						<td>{$a.f_fecha|hace:true}</td>
   					<td id="moreinfo1_2"><a href="{$tsConfig.url}/moderacion/buscador/1/1/{$a.f_ip}" class="geoip" target="_blank">{$a.f_ip}</a></td>
						<td class="admin_actions">
							<a href="{$tsConfig.url}/posts/editar/{$a.file_id}" title="Editar Archivo"><i data-feather="edit-3"></i></a>
							<a href="#" onclick="admin.file.borrar({$a.file_id}, 0); return false" title="Borrar Archivo permanentemente"><i data-feather="trash"></i></a>
						</td>
					</tr>
				{/foreach}
				</tbody>
				<tfoot>
					<td colspan="7">P&aacute;ginas: {$tsAdminFiles.pages}</td>
				</tfoot>
			</table>
		{/if}
	{/if}
</div>