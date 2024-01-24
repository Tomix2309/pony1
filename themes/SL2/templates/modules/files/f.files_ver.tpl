<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
   <div class="archivo">
      <div class="archivo-header d-flex justify-content-between align-items-center">
         <div>
             <h4 class="m-0">{$tsArchivo.data.arc_name}</h4>
            <small class="fst-italic">{$tsArchivo.data.arc_name}.{$tsArchivo.data.arc_ext}</small>
         </div>
         <div>
            {if $tsArchivo.data.arc_user == $tsUser->uid || $tsUser->is_admod}
               <a href="#" onclick="editar_nombre({$tsArchivo.data.file_id}, '{$tsArchivo.data.arc_name}', false); return false;"><i data-feather="edit-2"></i></a>
               <a href="#" class="File_privado_b{$tsArchivo.data.file_id}"{if $tsArchivo.f_privado == 1} style="display: none;"{/if} onclick="file_private({$tsArchivo.data.file_id}, 1); return false;" title="Cambiar a privado"><i data-feather="lock"></i></a>
               <a href="#" class="File_privado_b{$tsArchivo.data.file_id}"{if $tsArchivo.f_privado == 0} style="display: none;"{/if} onclick="file_private({$tsArchivo.data.file_id}, 0); return false;" title="Cambiar a p&uacute;blico"><i data-feather="unlock"></i></a>
               <a href="#" onclick="borrar_file({$tsArchivo.data.file_id}, false); return false;"><i data-feather="trash-2"></i></a>
               <input type="hidden" id="del_file" value="true" />
            {/if}
            <!--  <span id="File_Fav" {if $tsArchivo.mifav.act == 0}style="display: none;"{/if} title="Lo tienes en tus favoritos"><i data-feather="star"></i></span> -->
            <span id="File_Fav" title="Lo tienes en tus favoritos"><i data-feather="star"></i></span>
         </div>
      </div>
   </div>
   <div class="archivo-visor">
      {if $tsArchivo.data.arc_status == 0}
         <div class="alert text-danger">Este archivo ha sido eliminado, puedes verlo porque eres {if $tsUser->is_admod == 1}administrador <br />Para eliminarlo definitivamente haz click <a href="javascript:adminborrar_file({$tsArchivo.data.arc_id}, false);" class="text-danger fw-bold">aqui</a>{else}moderador{/if}.<br />Puedes reactivarlo <a href="javascript:reactivar_file({$tsArchivo.data.arc_id})" class="text-danger fw-bold">Aqui</a></div>
      {/if}
      {include "f.files_ver_archivo.tpl"}
   </div>
	<div class="box-lateral">
      <div class="box-body">
         {* DETALLES *}
         <div class="d-flex justify-content-between align-items-center">
            <div>
               <span class="d-block">Subido <b>{$tsArchivo.data.arc_date|hace}</b></span>
               <span>Tamaño: <b>{$tsArchivo.data.arc_weight}</b></span>
               {if $tsUser->is_admod} 
                  <a href="{$tsConfig.url}/moderacion/buscador/1/1/{$tsArchivo.data.arc_ip}" class="small fw-bold text-uppercase" target="_blank">{$tsArchivo.data.arc_ip}</a>
               {/if}
            </div>
            <div class="d-flex justify-content-center align-items-center">
               {if $tsArchivo.data.arc_user != $tsUser->uid}
                  <a class="btn btn-sm btn-primary me-2" id="btnfavorito" href="{if !$tsUser->is_member}{$tsConfig.url}/registro/{else}javascript:Files.archivo.favorito({$tsArchivo.data.arc_id}){/if}">{if $tsFavs}Guardado en{else}A{/if} Favoritos</a>
               {/if}
               <a href="{$tsConfig.url}/files/descargar/{$tsArchivo.data.arc_code}" class="btn btn-success btn-sm" id="btn_downloadfile">DESCARGAR</a>
            </div>
         </div>
      </div>
   </div>
   <br />
   {* Comentarios del archivo *}
   <div class="row">
      <div class="col"></div>
      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
         {include "f.files_ver_comentarios.tpl"}
      </div>
      <div class="col"></div>
   </div>
   
</div>
