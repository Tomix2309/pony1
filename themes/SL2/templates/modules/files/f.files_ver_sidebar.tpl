<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
   
   {if $tsUser->is_member}
   <div class="mb-2 d-grid gap-2">
      <a class="rounded text-success-emphasis border-0 bg-success-subtle p-3 icon-link icon-link-hover" href="{$tsConfig.url}/files/subir/"><i data-feather="upload-cloud"></i> Subir archivo</a>
   </div>
   {/if}

   <div class="box-lateral">
      <div class="box-header">Uploader <i data-feather="upload"></i></div>
      <div class="box-body">
         <a href="{$tsConfig.url}/perfil/{$tsAutor.user_name}" class="d-block my-3 text-center" title="{$tsAutor.user_name}">
            <img src data-src="{$tsAutor.user_avatar}" class="w-50 rounded shadow image mb-2 mx-auto d-block" alt="Autor del archivo" />
            <span class="badge badge-pill" style="background:#{$tsAutor.r_color};">{$tsAutor.user_name}</span>
         </a>
         <a href="{$tsConfig.url}/files/{$tsAutor.user_name}" class="w-100 btn btn-sm btn-block btn-primary">Ver m&aacute;s archivos</a>
      </div>
   </div>
   
   {* USUARIOS QUE HAN AGREGADO A FAVORITOS *}
   <div class="box-lateral">
      <div class="box-header">Favoritos <span class="fw-bolder">{$tsArchivo.fav.total}</span></div>
      <div class="box-body">
         {if $tsArchivo.fav.total > 0}
            {foreach from=$tsArchivo.fav.data item=a}
               <a href="{$tsConfig.url}/perfil/{$a.user_name}" class="d-grid gap-0 column-gap-2 p-1 mb-1" style="grid-template-columns:50px 1fr;">
                  <img src="{$a.user_avatar}" class="avatar rounded avatar-lg avatar-circle shadow" title="{$a.fav_date|fecha}" />
                  <div class="">
                     <span class="text-capitalize text-capitalize">{$a.user_name}</span>
                     <small class="d-flex fst-italic" style="font-size:.7rem;">{$a.fav_date|fecha}</small>
                  </div>
               </a>
            {/foreach}
         {else}
            <div class="alert alert-warning text-center">Nadie ha agregado a favoritos</div>
         {/if}
      </div>
   </div>
</div>