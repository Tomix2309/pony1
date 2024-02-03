{if ($tsAction == 'agregar' && ($tsUser->permisos.gopf || $tsUser->is_admod)) || ($tsAction == 'editar' && ($tsUser->permisos.moedfo || $tsUser->is_admod))} 
<h2>{if $tsAction == 'agregar'}Agregar nueva{else}Editar{/if} foto</h2>
<form name="add_foto" method="post" enctype="multipart/form-data" id="foto_form" class="form-add-post" autocomplete="off">
   <div class="loader text-center" style="display:none;">
      <div class="bg-light py-4">
         <div class="loading loading-lg success"></div>
         <h4 class="text-uppercase fw-bold py-2">Cargando foto, espere por favor....</h4>
      </div>
   </div>
   <div class="fade_out">
      <ul class="list-unstyled">
         <li class="position-relative form-group">
            <label class="form-label" for="ftitle">T&iacute;tulo</label>
            <span style="display: none;" class="errormsg"></span>
            <input type="text" tabindex="1" name="f_title" id="ftitle" maxlength="40" class="form-control required" value="{$tsFoto.f_title}"/>
         </li>
         {if $tsAction != 'editar'}
            {if $tsConfig.c_allow_upload == 1}
               <li class="position-relative form-group">
                  <label class="form-label" for="ffile">Archivo</label>
                  <input type="file" class="form-control" name="f_url" id="ffile" />
               </li>
            {else}
               <li class="position-relative form-group">
                  <label class="form-label" for="furl">URL</label>
                  <span style="display: none;" class="errormsg"></span>
                  <input type="text" tabindex="2" name="f_url" id="furl" class="form-control required" value="{$tsFoto.f_url}"/>
               </li>                            
            {/if}
         {/if}
         <li class="position-relative form-group">
            <label class="form-label" for="fdesc">Descripci&oacute;n <small>(Max 500 car.)</small></label>
            <span style="display: none;" class="errormsg"></span>
            <textarea name="desc" class="form-control" id="f_description" cols="60" rows="5">{$tsFoto.f_description}</textarea>
         </li>
         <li class="position-relative form-group">
            <label class="form-label">Opciones</label>
            <div class="option clearbeta">  
               <input type="checkbox" id="sin_comentarios" name="f_closed"{if $tsFoto.f_closed == 1} checked{/if}/> <label for="sin_comentarios">Cerrar Comentarios</label>
            </div>
				<div class="option clearbeta">  
               <input type="checkbox" class="floatL" id="visitas" name="f_visitas"{if $tsFoto.f_visitas == 1} checked{/if}/> <label for="visitas">&Uacute;ltimos visitantes</label>
            </div>
         </li>
         {if $tsUser->is_admod > 0 && $tsAction == 'editar' && $tsFoto.f_user  != $tsUser->uid}
            <li class="position-relative form-group">
               <label class="form-label">Raz&oacute;n</label>
               <input type="text" tabindex="8" name="razon" maxlength="150" size="60" class="form-input" placeholder="Si has modificado el contenido de esta foto, ingresa la raz&oacute;n." value=""/>
            </li>
         {/if}
      </ul>
      <div class="d-flex justify-content-center align-items-center">
         <input type="button" class="btn btn-{if $tsAction == 'agregar'}success{else}info{/if}" name="new" value="{if $tsAction == 'agregar'}Agregar foto{else}Guardar cambios{/if}" onclick="fotos.agregar()"/>
      </div>
   </div>                    
</form>
{else}
	<div class="alert alert-warning text-center">Lo sentimos, pero no puedes {if $tsAction == 'agregar'}agregar{else}editar{/if} una nueva foto.</div>
{/if}