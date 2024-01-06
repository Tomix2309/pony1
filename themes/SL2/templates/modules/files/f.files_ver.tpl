<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
	<div class="box-lateral">
      <div class="box-header">
         <span><span id="File_nombre">{$tsFile.data.f_nombre|truncate:75}</span>.{$tsFile.data.f_ext}</span>
         <span id="File_Fav" {if $tsFile.mifav.act == 0}style="display: none;"{/if} title="Lo tienes en tus favoritos"><i data-feather="star"></i></span>
      </div>
      {if $tsFile.data.f_user == $tsUser->uid || $tsUser->is_admod}
      <div class="d-flex justify-content-start align-items-center">
         <a href="#" onclick="editar_nombre({$tsFile.data.file_id}, '{$tsFile.data.f_nombre}', false); return false;" class="btn btn-sm btn-block btn-primary">Editar</a>
         <a href="#" class="btn btn-sm btn-block btn-success qtip File_privado_b{$tsFile.data.file_id}" {if $tsFile.data.f_privado == 1}style="display: none;"{/if} onclick="file_private({$tsFile.data.file_id}, 1); return false;" title="Cambiar a privado">Privado</a>
         <a href="#" class="btn btn-sm btn-block btn-success qtip File_privado_b{$tsFile.data.file_id}" {if $tsFile.data.f_privado == 0}style="display: none;"{/if} onclick="file_private({$tsFile.data.file_id}, 0); return false;" title="Cambiar a p&uacute;blico">P&uacute;blico</a>
         <a href="#" onclick="borrar_file({$tsFile.data.file_id}, false); return false;" class="btn btn-sm btn-block btn-danger">Borrar</a>
         <input type="hidden" id="del_file" value="true" />
      </div>
      {/if}
      <div class="box-body">
      	{if $tsFile.data.f_estado == 0}
            <div class="alert alert-danger text-center" id="File_deleted">Este archivo ha sido eliminado, puedes verlo porque eres {if $tsUser->is_admod == 1}administrador <br />Para eliminarlo definitivamente haz click <a onclick="adminborrar_file({$tsFile.data.file_id}, false);">aqui</a>{else}moderador{/if}.<br />Puedes reactivarlo <a onclick="reactivar_file({$tsFile.data.file_id})">Aqui</a></div>
         {/if}
    	   {include "$tsModulos/f.files_ver_archivo.tpl"}
         {* DETALLES *}
         <div class="d-flex justify-content-between align-items-center">
            <div>
               <span class="d-block">Subido <b>{$tsFile.data.f_fecha|hace}</b></span>
               <span>Tamaño: <b>{$tsFile.data.f_peso}</b></span>
               {if $tsUser->is_admod == 1} <a href="{$tsConfig.url}/moderacion/buscador/1/1/{$tsFile.data.f_ip}" class="text-dark small fw-bold text-uppercase" target="_blank">{$tsFile.data.f_ip}</a>{/if}
            </div>
            <div class="d-flex justify-content-center align-items-center">
               {if $tsFile.data.f_user != $tsUser->uid}
               <input type="button" onclick="{if !$tsUser->is_member}registro_load_form(){else}{if $tsFile.mifav.act != 1}favorit_file({$tsFile.data.file_id}){else}borrar_fav({$tsFile.mifav.fav_id}, false); return false;{/if}{/if}" class="btn btn-{if $tsFile.mifav.act != 1}info{else}danger{/if} btn-sm" value="{if $tsFile.mifav.act != 1}Favoritos{else}Borrar favoritos{/if}"{if $tsFile.mifav.act != 1} id="btn_favoritfile"{/if} />
               {/if}
               <input type="button" onclick="download_file({$tsFile.data.file_id})" class="btn btn-success btn-sm" value="DESCARGAR" id="btn_downloadfile">
            </div>
         </div>
      </div>
   </div>
   <br />
   {* Comentarios del archivo *}
   <div class="row">
      <div class="col"></div>
      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
         {include "$tsModulos/f.files_ver_comentarios.tpl"}
      </div>
      <div class="col"></div>
   </div>
   
</div>
