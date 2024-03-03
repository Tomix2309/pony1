<div class="content-tabs cambiar-clave">
   <fieldset>
      <div class="alert-cuenta cuenta-3"></div>
       <div class="form-group">
           <label class="form-label" for="new_passwd">Contrase&ntilde;a actual:</label>
           <input type="password" value="" onfocus="this.removeAttribute('readonly');" readonly placeholder="Contrase&ntilde;a actual" maxlength="32" name="passwd" id="passwd" class="form-input cuenta-save-3" autocomplete="off"/>
       </div>
       <div class="form-group">
           <label class="form-label" for="passwd">Contrase&ntilde;a nueva:</label>
           <input type="password" value="" onfocus="this.removeAttribute('readonly');" readonly placeholder="Contrase&ntilde;a nueva" maxlength="32" name="new_passwd" id="new_passwd" class="form-input cuenta-save-3"/>
       </div>
       <div class="form-group">
           <label class="form-label" for="confirm_passwd">Repetir Contrase&ntilde;a:</label>
           <input type="password" value="" onfocus="this.removeAttribute('readonly');" readonly placeholder="Repetir Contrase&ntilde;a" maxlength="32" name="confirm_passwd" id="confirm_passwd" class="form-input cuenta-save-3"/>
       </div>
   </fieldset>
   <div class="d-flex justify-content-center align-items-center">
       <input type="button" value="Guardar" onclick="cuenta.save(3)" class="btn btn-success"/>
   </div>
</div>