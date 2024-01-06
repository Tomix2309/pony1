<div class="boxy-title">
   <h3>Administrar Temas</h3>
</div>
<div id="res" class="boxy-content">
{if $tsSave}<div class="alert alert-info">Tus cambios han sido guardados.</div>{/if}
{if $ttSave}<div class="alert alert-info">El theme ha sido instalado correctamente</div>{/if}
   <div id="form_upload" style="display:none;">
      <form id="New_upload" name="theme" action="{$tsConfig.url}/admin-instalar-tema.php" method="post" enctype="multipart/form-data">
         <div id="Select_file">
            <a href="#" onclick="javascript: void(0);">Seleccionar archivo o arrastra el archivo aquí...<input type="file" name="zip_file" id="New_file" /></a>
         </div>
         <div class="install">
            <div class="result_text"></div>
            <input type="submit" value="Subir archivo" id="start_upload" class="Fbtn" style="display: none;" />
         </div>
      </form>
      <div id="progress"><div id="bar"></div><div id="percent">0%</div></div><div id="message"></div>
   </div>
   {if $tsAct == ''}
	<div class="fieldset my-4">
      <dl>
         <dt><labe for="">Nombre del theme actual</labe></dt>
         <dd><input type="text" class="form-input" disabled value="{$tsTemaSelet.t_name}" /></dd>
      </dl>
      <dl>
         <dt><labe for="">Autor</labe></dt>
         <dd><input type="text" class="form-input" disabled value="{$tsTemaSelet.t_copy}" /></dd>
      </dl>
      <dl>
         <dt><labe for="">Seleccionar nuevo theme</labe></dt>
         <dd>
            <select class="form-select {$tsTemaSelet.t_name|replace:' ':'_'}" id="themesClick">
               <option value="0">Seccion un theme</option>
               {foreach from=$tsTemas item=tema}
                  <option value="{$tema.tid}" {if $tsConfig.tema_id == $tema.tid}selected{/if}>{$tema.t_name}</option>
               {/foreach}
            </select>
            <div id="theme"></div>
         </dd>
      </dl>
   </div>
   <input type="button" onclick="$('#form_upload').toggle(200);return false;" value="Instalar nuevo tema" class="btn btn-primary">
   {elseif $tsAct == 'editar'}
   <div class="card mb-3">
      <div class="row no-gutters">
         <div class="col-md-4 mt-4">
            <img src="{$tsTema.t_url}/screenshot.png" class="rounded w-100 mx-auto d-block" alt="Previa del tema">
         </div>
         <div class="col-md-9">
            <div class="card-body">
               <h5 class="card-title">{$tsTema.t_name}</h5>
               <form action="" method="post" id="admin_form" autocomplete="off">
                  <div class="form-group">
                     <label for="ai_url">Url completa de la plantilla:</label>
                     <input type="text" id="ai_url" name="url" class="form-input" value="{$tsTema.t_url}" size="30" />
                  </div>
                  <div class="form-group">
                     <label for="ai_path">Nombre de la carpeta donde esta el tema:</label>
                     <input type="text" id="ai_path" name="path" class="form-input" value="{$tsTema.t_path}" size="30" />
                  </div>
                  <input type="submit" value="Guardar tema" name="save" class="btn btn-sm btn-success" style="margin-top:1em;">
               </form>
            </div>
         </div>
      </div>
   </div>
   {elseif $tsAct == 'usar' || $tsAct == 'borrar'}
   <form action="" method="post" id="admin_form" autocomplete="off">
      <h3>{$tt}</h3>
      {if $tsAct == 'borrar'}
         <span class="d-block">Solo tendrás que eliminar la el theme <b>{$tt}</b> manualmente de tu servidor!</span>
      {/if}
      <input type="submit" name="confirm" value="Confirmar &raquo;" class="btn btn-{if $tsAct == 'usar'}success{else}danger{/if}">
      
   </form>
   {elseif $tsAct == 'nuevo'}
   {if $tsError}<div class="alert alert-danger">{$tsError}</div>{/if}
   <form action="" method="post" id="admin_form" class="form-group" autocomplete="off">
      <label for="ai_path">Nombre de la carpeta donde esta el tema a instalar:</label>
      <div class="input-group">
         <div class="input-group-addon">{$tsConfig.url}/themes/</div>
         <input type="text" id="ai_path" name="path" placeholder="name_theme" class="form-control">
      </div>
      <hr />
      <label>&nbsp;</label> <input type="submit" value="Instalar tema" class="btn btn-success">
   </form>
   {/if}
</div>