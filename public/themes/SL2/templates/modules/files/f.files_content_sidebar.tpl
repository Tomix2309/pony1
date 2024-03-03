<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 col-xx-3">

	{if $tsAction == 'mis-archivos'} 
      <div class="box-lateral mb-4" id="FA_seleccionados">
         <div class="box-body" align="center">
         	<a class="btn btn-block btn-success" onclick="check.todos(); return false;" href="#" title="Seleccionar todos los archivos">Todos</a>
         </div>
         <div class="box-header">Archivos seleccionados</div>
         <div class="box-body" align="center">
         	<a class="btn btn-block mb-3 btn-info" onclick="check.cargar(); return false;" href="#" title="Mover archivos seleccionados">Mover</a>
         	<a class="btn btn-block mb-3 btn-danger" onclick="check.borrar(); return false;" href="#" title="Eliminar archivos seleccionados">Borrar</a>
         </div>
      </div>
   {/if}

   <div class="mb-2 d-grid gap-2">
      <a class="rounded text-success-emphasis border-0 bg-success-subtle p-3 icon-link icon-link-hover" href="{$tsConfig.url}/files/subir/"><i data-feather="upload-cloud"></i> Subir archivo</a>
      <a class="rounded text-success-emphasis border-0 bg-success-subtle p-3 icon-link icon-link-hover" href="javascript:Files.carpeta.crear(false)"><i data-feather="folder-plus"></i> Nueva carpeta</a>
   </div>

   <div class="box-lateral mb-4">
      <div class="box-header">Mis carpetas <i data-feather="folder"></i></div>
      <div class="box-body">
      	<div class="carpetas">
         	{foreach $tsCarpetas key=c item=carpeta}
         		<a id="carpeta-{$carpeta.car_id}" href="{$tsConfig.url}/files/{if empty($carpeta.car_pass)}carpeta{else}encriptado{/if}/{$carpeta.car_seo}" class="carpeta">
         			<img class="images" src="{$tsConfig.images}/files/carpeta-{$carpeta.ct_name}.png" alt="{$carpeta.car_seo}">
                  <div class="carpeta-info">
   	      			<span class="d-block">{$carpeta.car_name}</span>
                     <small>{$carpeta.arc_total|kmg} Archivo{if $carpeta.arc_total > 1}s{/if}</small>
                  </div>
         		</a>
         	{/foreach}
      	</div>
      </div>
   </div>
</div>