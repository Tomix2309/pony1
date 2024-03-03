<form name="change_background_user">
   <input type="hidden" name="pid" value="{$tsUser->uid}">

   <div class="form-group">
      <label class="form-label">Página</label>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="setting_type" value="pexels" id="Pexels"{if $SL2User.setting_type == 'pexels'} checked{/if}>
         <label class="form-check-label" for="Pexels">Pexels</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="setting_type" value="unsplash" id="unsplash"{if $SL2User.setting_type == 'unsplash'} checked{/if}>
         <label class="form-check-label" for="unsplash">Unsplash</label>
      </div>
   </div>

   <div class="form-group">
      <label class="form-label" for="portada">ID de imagen</label>
      <input type="text" name="setting_id" id="portada" value="{$SL2User.setting_id}" class="form-control">
   </div>
   
   <!-- Tamaño de la imagen -->
   <h4 class="py-1 px-2 m-0">Tamaño</h4>
   <div class="form-group">
      <label class="form-label" for="width">Anchura de la imagen</label>
      <input type="number" name="setting_width" id="width" value="{$SL2User.setting_width}" class="form-control">
   </div>
   <div class="form-group">
      <label class="form-label" for="height">Altura de la imagen</label>
      <input type="number" name="setting_height" id="height" value="{$SL2User.setting_height}" class="form-control">
   </div>
 
   <!-- Asignamos los estilos para la portada -->
   <h4 class="py-1 px-2 m-0">Estilos CSS</h4>
   <div class="form-group">
      <label class="form-label" for="posicion">Posición de la imagen</label>
      <select id="posicion" class="form-select" name="setting_position">
         <option value="0"{if $SL2User.setting_position == 0} selected{/if}>Left top</option>
         <option value="1"{if $SL2User.setting_position == 1} selected{/if}>Left center</option>
         <option value="2"{if $SL2User.setting_position == 2} selected{/if}>Left bottom</option>
         <option value="3"{if $SL2User.setting_position == 3} selected{/if}>Right top</option>
         <option value="4"{if $SL2User.setting_position == 4} selected{/if}>Right center</option>
         <option value="5"{if $SL2User.setting_position == 5} selected{/if}>Right bottom</option>
         <option value="6"{if $SL2User.setting_position == 6} selected{/if}>Center top</option>
         <option value="7"{if $SL2User.setting_position == 7} selected{/if}>Center center</option>
         <option value="8"{if $SL2User.setting_position == 8} selected{/if}>Center bottom</option>
      </select>
      <small class="text-muted">Referencias en w3schools:<a class="fw-bold text-primary-emphasis" href="https://www.w3schools.com/cssref/pr_background-position.asp" target="_blank">background-position</a></small>
   </div>
   
   <div class="form-group">
      <label class="form-label" for="repetir">Repetir la imagen</label>
      <select id="repetir" class="form-select" name="setting_repeat">
         <option value="0"{if $SL2User.setting_repeat == 0} selected{/if}>Repeat</option>
         <option value="1"{if $SL2User.setting_repeat == 1} selected{/if}>Repeat-x</option>
         <option value="2"{if $SL2User.setting_repeat == 2} selected{/if}>Repeat-y</option>
         <option value="3"{if $SL2User.setting_repeat == 3} selected{/if}>No-repeat</option>
      </select>
      <small class="text-muted">Referencias en w3schools:<a class="fw-bold text-primary-emphasis" href="https://www.w3schools.com/cssref/pr_background-repeat.asp" target="_blank">background-repeat</a></small>
   </div>

   <div class="form-group">
      <label class="form-label" for="size">Tamaño imagen</label>
      <input type="text" name="setting_size" id="size" value="{$SL2User.setting_size}" class="form-control">
      <small class="text-muted">Referencias en w3schools: <a class="fw-block text-primary-emphasis" rel="external" href="https://www.w3schools.com/cssref/css3_pr_background-size.asp" target="_blank">background-size</a></small>
   </div>

</form>