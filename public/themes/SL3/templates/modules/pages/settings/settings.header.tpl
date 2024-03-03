<!-- Administración del header -->
<div class="my-3 mb-1 border-top border-bottom py-3 text-uppercase text-center">
   <h3 class="m-0">Administrar header</h3>
</div>
<form name="save_header_background">
   <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-12">
         <h4 class="fs-3 text-center py-3 border-bottom">Imágen</h4>
         <div class="form-group">
            <label class="form-label">Página</label>
            <div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="setting_type" value="pexels" id="Pexels"{if $SL2Site.setting_type == 'pexels'} checked{/if}>
                  <label class="form-check-label" for="Pexels">Pexels</label>
               </div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="setting_type" value="unsplash" id="unsplash"{if $SL2Site.setting_type == 'unsplash'} checked{/if}>
                  <label class="form-check-label" for="unsplash">Unsplash</label>
               </div>
            </div>
         </div>
         <div class="form-group">
            <label class="form-label" for="portada">ID de imagen</label>
            <input type="text" name="setting_id" id="portada" value="{$SL2Site.setting_id}" class="form-control">
         </div>
         <!-- Tamaño de la imagen -->
         <h4 class="fs-3 text-center py-3 border-bottom">Tamaño</h4>
         <div class="form-group">
            <label class="form-label" for="width">Anchura de la imagen</label>
            <input type="number" name="setting_width" id="width" value="{$SL2Site.setting_width}" class="form-control">
         </div>
         <div class="form-group">
            <label class="form-label" for="height">Altura de la imagen</label>
            <input type="number" name="setting_height" id="height" value="{$SL2Site.setting_height}" class="form-control">
         </div>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-12">
         <!-- Asignamos los estilos para la portada -->
         <h4 class="fs-3 text-center py-3 border-bottom">Estilos CSS</h4>
         <div class="form-group">
            <label class="form-label" for="posicion">Posición de la imagen</label>
            <select id="posicion" class="form-select" name="setting_position">
               <option value="0"{if $SL2Site.setting_position == 0} selected{/if}>Left top</option>
               <option value="1"{if $SL2Site.setting_position == 1} selected{/if}>Left center</option>
               <option value="2"{if $SL2Site.setting_position == 2} selected{/if}>Left bottom</option>
               <option value="3"{if $SL2Site.setting_position == 3} selected{/if}>Right top</option>
               <option value="4"{if $SL2Site.setting_position == 4} selected{/if}>Right center</option>
               <option value="5"{if $SL2Site.setting_position == 5} selected{/if}>Right bottom</option>
               <option value="6"{if $SL2Site.setting_position == 6} selected{/if}>Center top</option>
               <option value="7"{if $SL2Site.setting_position == 7} selected{/if}>Center center</option>
               <option value="8"{if $SL2Site.setting_position == 8} selected{/if}>Center bottom</option>
            </select>
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/pr_background-position.asp" target="_blank">background-position</a></small>
         </div>

         <div class="form-group">
            <label class="form-label" for="repetir">Repetir la imagen</label>
            <select id="repetir" class="form-select" name="setting_repeat">
               <option value="0"{if $SL2Site.setting_repeat == 0} selected{/if}>Repeat</option>
               <option value="1"{if $SL2Site.setting_repeat == 1} selected{/if}>Repeat-x</option>
               <option value="2"{if $SL2Site.setting_repeat == 2} selected{/if}>Repeat-y</option>
               <option value="3"{if $SL2Site.setting_repeat == 3} selected{/if}>No-repeat</option>
            </select>
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/pr_background-repeat.asp" target="_blank">background-repeat</a></small>
         </div>

         <div class="form-group">
            <label class="form-label" for="fijar">Desplazar imagen</label>
            <select id="fijar" class="form-select" name="setting_attachment">
               <option value="0"{if $SL2Site.setting_attachment == 0} selected{/if}>Scroll</option>
               <option value="1"{if $SL2Site.setting_attachment == 1} selected{/if}>Fixed</option>
               <option value="2"{if $SL2Site.setting_attachment == 2} selected{/if}>Local</option>
               <option value="3"{if $SL2Site.setting_attachment == 3} selected{/if}>Initial</option>
               <option value="4"{if $SL2Site.setting_attachment == 4} selected{/if}>Inherit</option>
            </select>
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/pr_background-attachment.asp" target="_blank">background-attachment</a></small>
         </div>

         <div class="form-group">
            <label class="form-label" for="size">Tamaño imagen</label>
            <input type="text" name="setting_size" id="size" value="{$SL2Site.setting_size}" class="form-control">
            <small class="text-muted">Referencias en w3schools: <a class="text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/css3_pr_background-size.asp" target="_blank">background-size</a></small>
         </div>
      </div>
   </div>
</form>
<p class="text-right">
   <a href="javascript:guardar.header()" class="btn btn-primary">Guardar Header</a>
</p>