<div class="boxy-title">
   <h3>Administrar Afiliados</h3>
</div>
<div id="res" class="boxy-content">
   {if $tsSave}<div class="alert alert-info">Tus cambios han sido guardados.</div>{/if}
   {if !$tsAct}
      {if !$tsAfiliados}
			<div class="hero hero-xl hero-secondary"><div class="hero-body">No hay afiliados.</div></div>
         <input type="button"  onclick="afiliado.nuevo(); return false" value="Agregar nuevo afiliado" class="btn btn-success"/>
      {else}
         <table class="table table-striped">
            <thead>
               <th>ID</th>
               <th>Afiliado</th>
               <th>Cuando</th>
               <th>Entrada</th>
               <th>Salida</th>
               <th>Estado</th>
               <th>Acciones</th>
            </thead>
            <tbody>{foreach from=$tsAfiliados item=af}
               <tr id="few_{$af.aid}">
                  <td>{$af.aid}</td>
                  <td><a href="{$af.a_url}" id="a_url_{$af.aid}" target="_blank"><span id="a_name_{$af.aid}">{$af.a_titulo}</span></a></td>
                  <td>{$af.a_date|hace}</td>
                  <td>{$af.a_hits_in}</td>
                  <td>{$af.a_hits_out}</td>
						<td id="status_afiliado_{$af.aid}">{if $af.a_active == 0}<font color="purple">Inactivo</font>{else}<font color="green">Activo</font>{/if}</td>
                  <td class="admin_actions">
                     <a href="afs/editar/{$af.aid}" title="Editar"><i data-feather="edit-3"></i></a>
                     <a href="#" onclick="ad_afiliado.detalles({$af.aid}); return false;" title="Detalles"><i data-feather="paperclip"></i></a>
							<a onclick="admin.afs.accion({$af.aid}); return false" title="Activar/Desactivar Afiliado"><i data-feather="refresh-ccw"></i></a>
                     <a href="#" onclick="admin.afs.borrar({$af.aid}); return false" title="Eliminar"><i data-feather="trash"></i></a>
                  </td>
               </tr>{/foreach}
            </tbody>
         </table>
         <br />
         <input type="button"  onclick="afiliado.nuevo(); return false" value="Agregar nuevo afiliado" class="btn btn-success"/>
      {/if}
   {elseif $tsAct == 'editar'}
		<form action="" method="post" autocomplete="off">
			<fieldset>
				<legend>Editar afiliado</legend>
				<dl>
					<dt><label for="af_name">T&iacute;tulo de afiliado:</label></dt>
					<dd><input type="text" id="af_name" class="form-input" name="af_title" value="{$tsAf.a_titulo}" /></dd>
				</dl>
				<dl>
					<dt><label for="af_url">Direcci&oacute;n:</label></dt>
					<dd><input type="text" id="af_url" class="form-input" name="af_url" value="{$tsAf.a_url}" /></dd>
				</dl>
				<dl>
					<dt><label for="af_banner">Banner:</label><br /><span>Imagen del afiliado:</span></dt>
					<dd><input type="text" id="af_banner" class="form-input" name="af_banner" value="{$tsAf.a_banner}" /></dd>
				</dl>
				<dl>
					<dt><label for="af_desc">Descripci&oacute;n:</label><br /><span>Descripci&oacute;n de la comunidad afiliada</span></dt>
					<dd><textarea class="form-input" name="af_desc" id="af_desc" rows="3" cols="40">{$tsAf.a_descripcion}</textarea></dd>
				</dl>
				<hr />
            <p><input type="submit" name="edit" value="Guardar" class="btn btn-success"/>
			</fieldset>
		</form>
	{/if}
</div>