<div class="boxy-title">
   <h3>Actualizaciones e información</h3>
</div>
<div id="res" class="boxy-content">
   <h4 class="mt-2 fw-bold">Información del desarrollo del theme</h4>  	
  	 <table class="table table-striped">
   	<thead>
   		<tr>
   			<th>Nombre</th>
   			<th>Autor</th>
   			<th>Versión Anterior</th>
   			<th>Versión Nueva</th>
   			<th>{if $tsFeed.my_theme_new != VersionTheme}Descargar{else}Estado{/if}</th>
   		</tr>
   	</thead>
   	<tbody>
   		<tr>
   			<td>{$tsFeed.my_theme_name}</td>
   			<td>{$tsFeed.my_theme_author}</td>
   			<td>{$tsFeed.my_theme_old}</td>
   			<td>{$tsFeed.my_theme_new}</td>
   			<td>{if $tsFeed.my_theme_new != VersionTheme}<a href="{$tsFeed.my_theme_download}" class="btn btn-sm btn-success">Actualizar</a>{else}<span class="fw-bold text-success">Actualizado</span>{/if}</td>
   		</tr>
   	</tbody>
   </table>
   
   <hr class="separator" />
   <h4>Templates desarrollados por los usuarios de PHPost</h4>
   <table class="table table-striped">
   	<thead>
   		<tr>
   			<th>Nombre</th>
   			<th>Autor</th>
   			<th>Versión</th>
   			<th>Estado</th>
   			<th>Descargar</th>
   		</tr>
   	</thead>
   	<tbody>
   		{foreach $tsFeed.themes item=t}
   		<tr>
   			<td>{$t.name}</td>
   			<td>{$t.author}</td>
   			<td>{$t.version}</td>
   			<td>{$t.status}</td>
   			<td><a href="{$t.link}" class="btn btn-sm btn-success">Descargar</a></td>
   		</tr>
   		{/foreach}
   	</tbody>
   </table>
   
</div>
                                    