<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
	<div class="file_box" id="SearchResult" style="display: none;"></div>
	<div class="row searching">
		<div class="bg-light col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
			<div class="box-lateral">
				<div class="box-header">Carpetas <span id="ftotal">{$folderUser.total}</span></div>
				<div class="carpetas">
					{if $folderUser.data}
					{foreach from=$folderUser.data item=f}
						<div class="lista_carpeta" id="folderid_{$f.folder_id}">
							<a class="d-flex justify-content-center align-items-center text-center" href="{$tsConfig.url}/files/{$filesUser.user_name}/{$f.folder_id}/{$f.folder_name|seo}"><i data-feather="folder"></i></a>
							<div class="F_info position-relative d-flex justify-content-center align-items-start flex-column">
								<a href="{$tsConfig.url}/files/{$filesUser.user_name}/{$f.folder_id}/{$f.folder_name|seo}" class="d-block" id="Folder_name">{$f.folder_name}</a>
								<span class="small"><span id="Folder_privado_{$f.folder_id}">{if $f.folder_priv == 1}Privada{else}P&uacute;blica{/if}</span> - {$f.folder_fecha|hace}</span>
								<div class="opciones">
									<i data-feather="sliders"></i>
									<div class="opcf rounded shadow">
										<a href="#" onclick="borrar_folder({$f.folder_id}); return false;" class="d-block text-danger">Borrar</a>
										<a href="#" onclick="editar_folder({$f.folder_id}, '{$f.folder_name}'); return false;" class="d-block text-info">Editar nombre</a>
										<a href="#" class="text-danger Folder_privado_{$f.folder_id}" {if $f.folder_priv == 1}style="display: none;"{/if} onclick="folder_private({$f.folder_id}, 1); return false;" title="Cambiar a privada">Cambiar a Privada</a>
										<a href="#" class="text-success Folder_privado_{$f.folder_id}" {if $f.folder_priv == 0}style="display: none;"{/if} onclick="folder_private({$f.folder_id}, 0); return false;" title="Cambiar a p&uacute;blica">Cambiar a P&uacute;blica</a>
									</div>
								</div>
							</div>
						</div>
					{/foreach}    
					{else}     
						<div class="alert alert-warning text-center" id="alert">Sin carpetas</div>
					{/if}
					<div id="F_newfolder"></div>       
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
		{************** ULTIMOS PUBLICOS ***************}
			{if !$folderUser.nombre && $tsLastFiles.data}
			<div class="box-lateral">
				 <h2 class="box-header">Ultimos Archivos p&uacute;blicos</h2>
				 <div class="box-body">            
					  <div id="more_last_files" class="F_files">
						  {include file='t.php_files/p.files.last-files.tpl'}
					  </div>
				 </div>
			</div>
			{/if}
			<div class="box-lateral">
				 <h2 class="box-header">{if $tsUser->uid == $filesUser.user_id}Mis archivos{else}Archivos subidos por {$filesUser.user_name}{/if} {$folderUser.nombre}<span class="fw-bolder" id="Files_total">{if $filesUser.pages.limit+20|number_format > $filesUser.total}{$filesUser.total}{else}{$filesUser.pages.limit+20|number_format}{/if} de {$filesUser.total}</span></h2>
				 <div class="d-flex justify-content-start align-items-center">
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o=nombre&f=a" class="btn btn-sm text-{if $filesUser.o == 'nombre'}success{else}dark{/if}">Nombre</a>
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o=fecha&f=d" class="btn btn-sm text-{if $filesUser.o == 'fecha'}success{else}dark{/if}">Fecha</a>
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o=peso&f=p" class="btn btn-sm text-{if $filesUser.o == 'peso'}success{else}dark{/if}">Peso</a>
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o=descargas&f=a" class="btn btn-sm text-{if $filesUser.o == 'descargas'}success{else}dark{/if}">Descargas</a>
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o=ext&f=a" class="btn btn-sm text-{if $filesUser.o == 'ext'}success{else}dark{/if}">Tipo</a>
					  {if $filesUser.f == 'a'}
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o={$filesUser.o}&f=d" class="btn btn-sm text-dark">Descendente</a>
					  {elseif $filesUser.f == 'd'}
					  <a href="{$tsConfig.url}/files/{$filesUser.user_name}?o={$filesUser.o}&f=a" class="btn btn-sm text-dark">Ascendente</a>
					  {/if}
				 </div>
				<div class="box-body" >        
					{if $filesUser.total > 0 || $folderUser.total > 0}
					<div class="F_files">
						{foreach from=$filesUser.data item=a}
							<div class="list_file" id="File_{$a.file_id}" {if $a.f_estado == 0}style="opacity: 0.5;" title="Este archivo est&aacute; desabilitado"{/if}>
								<a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}">
									<div class="File_format d-flex justify-content-center align-items-center">
										<img src="{$tsConfig.images}/files/{$a.f_ext}.png" class="icon" alt="">
									</div>
								</a>
								<div class="F_info position-relative">
									<a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}" class="d-block"><h2 class="m-0 p-1 text-dark h5" id="File_nombre">{$a.f_nombre|truncate:75}</h2></a>
									<small class="text-secondary d-block"><input type="checkbox" name="file_id_box[]" value="{$a.file_id}" onclick="check.marcar();" /> {if $a.f_privado == 1}Privado{else}P&uacute;blico{/if} - {$a.f_fecha|hace} &bull; {$a.f_peso} &bull; Descargas: {$a.f_descargas} &bull; {$a.f_ext}</small>
									{if $tsUser->uid == $filesUser.user_id || $tsUser->is_admod}
										<div class="opciones">
											<i data-feather="sliders"></i>
											<div class="opcf rounded shadow">
												<a href="#" onclick="download_file({$a.file_id}); return false;" class="d-block px-2 text-success">Descargar</a>
												<a href="#" onclick="borrar_file({$a.file_id}, false); return false;" class="d-block px-2 text-danger">Borrar</a>
												{if $filesUser.user_id == $tsUser->uid}
													<a href="#" onclick="folder.cargar({$a.file_id}); return false;" class="d-block px-2 text-warning">Mover</a>
												{/if}
												<a href="#" onclick="editar_nombre({$a.file_id}, '{$a.f_nombre}', false); return false;" class="d-block px-2 text-primary">Editar nombre</a>
												<a href="#" class="px-2 text-danger File_privado_b{$a.file_id}" {if $a.f_privado == 1}style="display: none;"{/if} onclick="file_private({$a.file_id}, 1); return false;" title="Cambiar a privado">Cambiar a Privado</a>
												<a href="#" class="px-2 text-success File_privado_b{$a.file_id}" {if $a.f_privado == 0}style="display: none;"{/if} onclick="file_private({$a.file_id}, 0); return false;" title="Cambiar a p&uacute;blico">Cambiar a P&uacute;blico</a>
											</div>
										</div>
									{/if}
								</div>
							</div>
							{/foreach}
					  </div>
					  {else}
					  <div class="alert alert-warning text-center">{if $tsUser->uid == $filesUser.user_id}No has subido ning&uacute;n arhivo.{else}{$filesUser.user_name} no ha subido archivos.{/if}</div>
					  {/if}
				</div>
			</div>
			{if $filesUser.total > 5}
			<div class="d-flex justify-content-between align-items-center">
				 {if $filesUser.pages.prev}
				 <a href="{$tsConfig.url}/files/{$filesUser.user_name}/pagina{$filesUser.pages.prev}" class="btn btn-sm btn-primary">Anterior</a>
				 {/if}
				 {if $filesUser.pages.next}
				 <a href="{$tsConfig.url}/files/{$filesUser.user_name}/pagina{$filesUser.pages.next}" class="btn btn-sm btn-primary">Siguiente</a>
				 {/if}
			</div>
			{/if}
		</div>
	</div>
</div>