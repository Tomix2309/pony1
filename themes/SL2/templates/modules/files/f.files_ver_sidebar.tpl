<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
   <div class="box-lateral">
      <div class="box-header">Uploader <i data-feather="upload"></i></div>
      <div class="box-body">
         <a href="{$tsConfig.url}/perfil/{$tsFile.data.user_name}" class="d-block my-3 text-center" title="{$tsFile.data.user_name}">
            <img src="{$tsConfig.url}/files/avatar/{$tsFile.data.f_user}.webp" class="w-50 rounded shadow mb-2 mx-auto" alt="Autor del archivo" />
            <span class="d-block text-dark text-capitalize fw-bolder">{$tsFile.data.user_name}</span>
         </a>
         <a href="{$tsConfig.url}/files/{$tsFile.data.user_name}" class="btn btn-sm btn-block btn-primary">Ver m&aacute;s archivos</a>
      </div>
   </div>
   {if $tsUser->is_member}
      <div id="form_upload" class="text-center">
         <form id="New_upload" action="{$tsConfig.url}/files-subir.php" method="post" enctype="multipart/form-data">
            <div id="Select_file">
               <a href="javascript: void(0);"class="Fbtn btn btn-success btn-block btn-sm list_text">Seleccionar archivo
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
   {/if}
   
   {* USUARIOS QUE HAN DESCARGADO EL ARCHIVO *}
   <div class="box-lateral">
      <div class="box-header">Total descargas <span class="fw-bolder">{$tsFile.data.f_descargas}</span></div>
      <div class="box-body">
         {if $tsFile.users}
            {foreach from=$tsFile.users item=a}
               <a href="{$tsConfig.url}/perfil/{$a.user_name}" class="d-flex justify-content-start align-items-center">
                  <img src="{$tsConfig.url}/files/avatar/{$a.d_user}.webp" class="avatar rounded avatar-sm shadow" title="{if $a.d_total > 1}{$a.d_total} veces - {/if}{$a.d_fecha|hace}" />
                  <span class="text-capitalize text-dark text-capitalize ml-2">{$a.user_name}</span>
               </a>
            {/foreach}
         {else}
            <div class="alert alert-warning text-center">Nadie ha descargado este archivo</div>
         {/if}
      </div>
   </div>
   {* USUARIOS QUE HAN AGREGADO A FAVORITOS *}
   <div class="box-lateral">
      <div class="box-header">Favoritos <span class="fw-bolder">{$tsFile.total.favoritos}</span></div>
      <div class="box-body">
         {if $tsFile.total.favoritos > 0}
            {foreach from=$tsFile.favoritos item=a}
               <a href="{$tsConfig.url}/perfil/{$a.user_name}" class="d-flex justify-content-start align-items-center" >
                  <img src="{$tsConfig.url}/files/avatar/{$a.fav_user}.webp" class="avatar rounded avatar-sm shadow" title="{$a.fav_fecha|fecha}" />
                  <span class="text-capitalize text-dark text-capitalize ml-2">{$a.user_name}</span>
               </a>
            {/foreach}
         {else}
            <div class="alert alert-warning text-center">Nadie ha agregado a favoritos</div>
         {/if}
      </div>
   </div>
</div>