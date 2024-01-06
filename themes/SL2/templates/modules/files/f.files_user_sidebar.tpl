<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
   <div class="box-lateral">
      <div class="box-header">Uploader <i data-feather="upload"></i></div>
      <div class="box-body">
         <a href="{$tsConfig.url}/perfil/{$filesUser.user_name}" class="d-block my-3 text-center" title="{$filesUser.user_name}">
            <img src="{$tsConfig.url}/files/avatar/{$filesUser.user_id}.webp" class="w-50 rounded shadow mb-2 mx-auto" alt="Autor del archivo" />
            <span class="d-block text-dark text-capitalize fw-bolder">{$filesUser.user_name}</span>
         </a>
      </div>
   </div>
   {if $filesUser.user_id == $tsUser->uid}
      <div class="box-lateral mb-4" id="FA_seleccionados" style="display: none;">
         <div class="box-header">Seleccionados</div>
         <div class="box-body d-flex justify-content-center align-content-center" align="center">
           <a class="btn btn-block mx-1 btn-sm btn-success" onclick="check.todos(); return false;" href="#" title="Seleccionar todos los archivos">Todos</a>
           <a class="btn btn-block mx-1 btn-sm btn-info" onclick="check.cargar(); return false;" href="#" title="Mover archivos seleccionados">Mover</a>
           <a class="btn btn-block mx-1 btn-sm btn-danger" onclick="check.borrar(); return false;" href="#" title="Eliminar archivos seleccionados">Borrar</a>
           </div>
      </div>
   {/if}
	<div id="form_upload" class="text-center">
      <form id="New_upload" action="{$tsConfig.url}/files-subir.php" method="post" enctype="multipart/form-data">
         <div id="Select_file">
            <a href="javascript: void(0);" class="Fbtn btn btn-success btn-block text-uppercase btn-sm list_text">Seleccionar archivo
               <input type="file" name="archivo" id="New_file" />
            </a>
            <div class="result_text"></div>
         </div>
         <input type="submit" value="Subir archivo" id="start_upload" class="btn btn-sm btn-block btn-primary" style="display: none;" />
      </form>
      <div id="progress">
         <div id="bar"></div>
         <div id="percent">0%</div >
      </div>            
      <div id="message"></div>
	</div>

   <div class="box-lateral">
      <div class="box-header">Buscar archivos <i data-feather="search"></i></div>
      <div class="box-body">
         <form action="javascript: file_search({$filesUser.user_id}, {$folderUser.fid})" class="mt-2" name="f_search" method="post">
            <input type="text" id="F_search" title="Buscar en {if $tsUser->uid != $filesUser.user_id}los archivos de {$filesUser.user_name}{else}mis archivos{/if}" class="form-input" placeholder="Buscar archivos..." />
            <input type="submit" value="Buscar" class="btn btn-sm btn-primary btn-block" />
         </form>
      </div>
   </div>
   {if $filesUser.user_id == $tsUser->uid}
      <div class="box-lateral">
         <div class="box-header">Favoritos <span class="fw-bold">{$filesUser.total_favs}</span></div>
         <div class="box-body">
            {if $filesUser.total_favs > 0}
               {foreach from=$filesUser.favoritos item=f}
                  <div class="d-flex justify-content-start align-items-center" {if $f.f_estado == 0}style="opacity: 0.5;" title="Este archivo est&aacute; desabilitado"{/if}>
                     <a href="{$tsConfig.url}/perfil/{$f.user_name}" title="Subido por {$f.user_name}" class="mr-2"><img src="{$tsConfig.url}/files/avatar/{$f.f_user}.webp" class="avatar rounded shadow" height="30" width="30" /></a>
                     <a href="{$tsConfig.url}/files/{$f.file_id}/{$f.f_seo}" class="fw-bold text-dark">{$f.f_nombre|truncate:45}</a>
                  </div>
               {/foreach}
            {else}
               <div class="alert alert-warning text-center">No tienes archivos favoritos.</div>
            {/if}
         </div>
      </div>
   {/if}    
   <div class="box-lateral">
      <div class="box-header">Comentarios recientes <i data-feather="message-circle"></i></div>
      <div class="box-body">
         {if $getLastcom}
            {foreach from=$getLastcom item=f}
               <div class="d-flex mb-2 justify-content-start align-items-center" {if $f.f_estado == 0}style="opacity: 0.5;" title="Este archivo est&aacute; desabilitado"{/if}>
                  <a href="{$tsConfig.url}/perfil/{$f.user_name}" title="{$f.user_name}" class="mr-2">
                     <img src="{$tsConfig.url}/files/avatar/{$f.com_user}.webp" class="avatar rounded shadow" height="35" width="35" />
                  </a>
                  <span>
                     <a href="{$tsConfig.url}/files/{$f.file_id}/{$f.f_nombre|seo}" class="fw-bold text-dark" title="{$f.com_fecha|hace}">{$f.f_nombre|truncate:45}</a>
                     <small class="d-block">{$f.com_fecha|hace}</small>
                  </span>
               </div>
            {/foreach}
         {else}
            <div class="alert alert-warning text-center">No se han hecho comentarios a&uacute;n.</div>
         {/if}
      </div>
   </div>
</div>