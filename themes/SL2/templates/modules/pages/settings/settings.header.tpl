<!-- Administración del header -->
<div class="my-3 mb-1 border-top border-bottom py-3 text-uppercase text-center">
   <h3 class="m-0">Administrar header</h3>
</div>
<form name="confHeader">
   <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-12">
         <h4 class="fs-3 text-center py-3 border-bottom">Imágen</h4>
         <div class="form-group">
            <label class="form-label">Página</label>
            <div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="Pexels"{if $tsAdmInfo.web == 'pexels'} checked{/if}>
                  <label class="form-check-label" for="Pexels">Pexels</label>
               </div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="unplash"{if $tsAdmInfo.web == 'unplash'} checked{/if}>
                  <label class="form-check-label" for="unplash">Unplash</label>
               </div>
            </div>
         </div>
         <div class="form-group">
            <label class="form-label" for="portada">ID de imagen</label>
            <input type="text" name="id" id="portada" value="{$tsAdmInfo.id}" class="form-control">
         </div>
         <!-- Tamaño de la imagen -->
         <h4 class="fs-3 text-center py-3 border-bottom">Tamaño</h4>
         <div class="form-group">
            <label class="form-label" for="width">Anchura de la imagen</label>
            <input type="number" name="width" id="width" value="{$tsAdmInfo.width}" class="form-control">
         </div>
         <div class="form-group">
            <label class="form-label" for="height">Altura de la imagen</label>
            <input type="number" name="height" id="height" value="{$tsAdmInfo.height}" class="form-control">
         </div>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-12">
         <!-- Asignamos los estilos para la portada -->
         <h4 class="fs-3 text-center py-3 border-bottom">Estilos CSS</h4>
         <div class="form-group">
            <label class="form-label" for="posicion">Posición de la imagen</label>
            <select id="posicion" class="form-select" name="position">
               <option value="left top"{if $tsAdmInfo.position == "left top"} selected{/if}>Left top</option>
               <option value="left center"{if $tsAdmInfo.position == "left center"} selected{/if}>Left center</option>
               <option value="left bottom"{if $tsAdmInfo.position == "left bottom"} selected{/if}>Left bottom</option>
               <option value="right top"{if $tsAdmInfo.position == "right top"} selected{/if}>Right top</option>
               <option value="right center"{if $tsAdmInfo.position == "right center"} selected{/if}>Right center</option>
               <option value="right bottom"{if $tsAdmInfo.position == "right bottom"} selected{/if}>Right bottom</option>
               <option value="center top"{if $tsAdmInfo.position == "center top"} selected{/if}>Center top</option>
               <option value="center center"{if $tsAdmInfo.position == "center center"} selected{/if}>Center center</option>
               <option value="center bottom"{if $tsAdmInfo.position == "center bottom"} selected{/if}>Center bottom</option>
            </select>
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/pr_background-position.asp" target="_blank">background-position</a></small>
         </div>

         <div class="form-group">
            <label class="form-label" for="repetir">Repetir la imagen</label>
            <select id="repetir" class="form-select" name="repeat">
               <option value="repeat"{if $tsAdmInfo.repeat == "repeat"} selected{/if}>Repeat</option>
               <option value="repeat-x"{if $tsAdmInfo.repeat == "repeat-x"} selected{/if}>Repeat-x</option>
               <option value="repeat-y"{if $tsAdmInfo.repeat == "repeat-y"} selected{/if}>Repeat-y</option>
               <option value="no-repeat"{if $tsAdmInfo.repeat == "no-repeat"} selected{/if}>No-repeat</option>
            </select>
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/pr_background-repeat.asp" target="_blank">background-repeat</a></small>
         </div>

         <div class="form-group">
            <label class="form-label" for="fijar">Desplazar imagen</label>
            <select id="fijar" class="form-select" name="attachment">
               <option value="scroll"{if $tsAdmInfo.attachment == "scroll"} selected{/if}>Scroll</option>
               <option value="fixed"{if $tsAdmInfo.attachment == "fixed"} selected{/if}>Fixed</option>
               <option value="local"{if $tsAdmInfo.attachment == "local"} selected{/if}>Local</option>
               <option value="initial"{if $tsAdmInfo.attachment == "initial"} selected{/if}>Initial</option>
               <option value="inherit"{if $tsAdmInfo.attachment == "inherit"} selected{/if}>Inherit</option>
            </select>
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/pr_background-attachment.asp" target="_blank">background-attachment</a></small>
         </div>

         <div class="form-group">
            <label class="form-label" for="size">Tamaño imagen</label>
            <input type="text" name="size" id="size" value="{$tsAdmInfo.size}" class="form-control">
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/css3_pr_background-size.asp" target="_blank">background-size</a></small>
         </div>
      </div>
   </div>
</form>
<p class="text-right">
   <a href="javascript:guardar.header()" class="btn btn-primary">Guardar Header</a>
</p>