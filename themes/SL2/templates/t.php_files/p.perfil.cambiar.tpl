<form id="changeCover">
   <div class="row">
      <input type="hidden" name="pid" value="{$tsUser->uid}">
      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label">Página</label>
            <div>
               <label class="form-radio d-inline-block">
                  <input type="radio" value="pexels" name="sitio"{if $tsGetInfo.web == 'pexels'} checked{/if}>
                  <i class="form-icon"></i> Pexels
               </label>
               <label class="form-radio d-inline-block">
                  <input type="radio" value="unplash" name="sitio"{if $tsGetInfo.web == 'unplash'} checked{/if}>
                  <i class="form-icon"></i> Unplash
               </label>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="portada">ID de imagen</label>
            <input type="text" name="imagen" id="portada" value="{$tsGetInfo.id_img}" class="form-input">
         </div>
      </div>
   </div>
   <!-- Tamaño de la imagen -->
   <h4 class="bg-light py-1 px-2 m-0">Tamaño</h4>
   <div class="row">
      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="width">Anchura de la imagen</label>
            <input type="number" name="width" id="width" value="{$tsGetInfo.width}" class="form-input">
         </div>
      </div>
      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="height">Altura de la imagen</label>
            <input type="number" name="height" id="height" value="{$tsGetInfo.height}" class="form-input">
         </div>
      </div>
   </div>
   <!-- Asignamos los estilos para la portada -->
   <h4 class="bg-light py-1 px-2 m-0">Estilos CSS</h4>
   <div class="row">
      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="posicion">Posición de la imagen</label>
            <select id="posicion" class="form-select" name="position">
               <option value="left top"{if $tsGetInfo.position == "left top"} selected{/if}>left top</option>
               <option value="left center"{if $tsGetInfo.position == "left center"} selected{/if}>left center</option>
               <option value="left bottom"{if $tsGetInfo.position == "left bottom"} selected{/if}>left bottom</option>
               <option value="right top"{if $tsGetInfo.position == "right top"} selected{/if}>right top</option>
               <option value="right center"{if $tsGetInfo.position == "right center"} selected{/if}>right center</option>
               <option value="right bottom"{if $tsGetInfo.position == "right bottom"} selected{/if}>right bottom</option>
               <option value="center top"{if $tsGetInfo.position == "center top"} selected{/if}>center top</option>
               <option value="center center"{if $tsGetInfo.position == "center center"} selected{/if}>center center</option>
               <option value="center bottom"{if $tsGetInfo.position == "center bottom"} selected{/if}>center bottom</option>
            </select>
            <small class="text-muted">Referencias en w3schools:<a class="fw-bold text-primary" href="https://www.w3schools.com/cssref/pr_background-position.asp" target="_blank">background-position</a></small>
         </div>
      </div>
      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="repetir">Repetir la imagen</label>
            <select id="repetir" class="form-select" name="repeat">
               <option value="repeat"{if $tsGetInfo.repeat == "repeat"} selected{/if}>repeat</option>
               <option value="repeat-x"{if $tsGetInfo.repeat == "repeat-x"} selected{/if}>repeat-x</option>
               <option value="repeat-y"{if $tsGetInfo.repeat == "repeat-y"} selected{/if}>repeat-y</option>
               <option value="no-repeat"{if $tsGetInfo.repeat == "no-repeat"} selected{/if}>no-repeat</option>
            </select>
            <small class="text-muted">Referencias en w3schools:<a class="fw-bold text-primary" href="https://www.w3schools.com/cssref/pr_background-repeat.asp" target="_blank">background-repeat</a></small>
         </div>
      </div>
   </div>
</form>