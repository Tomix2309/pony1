<div class="form-group"> 
   <label class="form-label">T&iacute;tulo</label>
   <span style="display: none;" class="errormsg"></span>
   <input type="text" tabindex="1" name="titulo" maxlength="60" size="60" class="form-input required" value="{$tsDraft.b_title}"/>
   <div id="repost"></div>
</div>
<div class="form-group"> 
   <label class="form-label">Portada</label>
   <span style="display: none;" class="errormsg"></span>
   <input type="text" tabindex="2" name="imagen" class="form-input required" value="{$tsDraft.b_portada}" />
   <p style="color:#999;font-size: 11px;margin: 2px 0 5px 2px;">URL de la imagen como caratula para la home</p>
</div> 
<div class="form-group"> 
   <a name="post"></a>
   <label class="form-label">Contenido del Post</label>
   <span style="display: none;" class="errormsg"></span>
   <textarea id="markItUp" name="cuerpo" tabindex="2" style="min-height:400px;" class="required">{$tsDraft.b_body}</textarea>
</div>
<div class="form-group"> 
   <label class="form-label">Tags</label>
   <span style="display: none;" class="errormsg"></span>
   <input type="text" tabindex="4" name="tags" maxlength="128" class="form-input required" value="{$tsDraft.b_tags}" placeholder="{$tsConfig.titulo}, posts, crear, nuevo, música, videos, imagenes, etc" />
</div>
{if ($tsUser->is_admod > 0 || $tsUser->permisos.moedpo) && $tsDraft.b_title && $tsDraft.b_user != $tsUser->uid}
   <div class="form-group"> 
      <label>Raz&oacute;n</label>
      <span style="display: none;" class="errormsg"></span>
      <input type="text" placeholder="Si has modificado el contenido de este post ingresa la raz&oacute;n por la cual lo modificaste." tabindex="8" name="razon" maxlength="150" size="60" class="form-input" value="" />
   </div>
{/if}
<div class="d-flex justify-content-between align-items-center">
   <div>
      <span class="btn btn-secondary" id="borrador-save">Guardar</span>
      <span class="btn btn-success" id="publicar">Vista previa</span>
      <span class="btn btn-primary" id="vista_previa">Publicar ahora!</span>
   </div>
   <div id="borrador-guardado" style="float: right; font-style: italic; margin: 7px 0pt 0pt;"></div>
</div>