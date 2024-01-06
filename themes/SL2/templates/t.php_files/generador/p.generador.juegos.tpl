<div class="caja big">
   <h2>Descripción</h2>
   <div class="form-group">
      <textarea id="contenent_body" data-type="Sinopsis" style="height:100px" class="form-input"></textarea>
   </div>
</div>
<!-- PARA JUEGOS -->
<div class="caja big">
   <h2>Ficha técnica</h2>
   <div class="form-group">
      <p class="form-label">Información del archivo</p>
      <div class="row">
         <div class="col-sm-4 mb-3"><input data-type="PLATAFORMA" id="plataforma" class="form-input" placeholder="ej: Pc, PS2, etc" type="text" /></div>
         <div class="col-sm-4 mb-3"><input data-type="PESO TOTAL" id="pesototal" class="form-input" placeholder="ej: 8GB" type="text" /></div>
         <div class="col-sm-4 mb-3"><input data-type="FORMATO" id="formato" class="form-input" placeholder="ej: ISO, RAR, EXE, etc" type="text" /></div>
         <div class="col-sm-4 mb-3"><input data-type="IDIOMAS" id="idiomas" class="form-input" placeholder="Es, En, Ru" type="text" /></div>
         <div class="col-sm-4 mb-3"><input data-type="ESTRENO" id="fechaestreno" class="form-input" placeholder="Fecha de estreno (dd/mm/aaaa)" type="text" /></div>
         <div class="col-sm-4 mb-3"><input data-type="ACTUALIZACION" id="fechaactualizacion" class="form-input" placeholder="Fecha de actualización (dd/mm/aaaa)" type="text" /></div>
         <div class="col-sm-12"><input data-type="GÉNEROS" id="generosg" class="form-input" placeholder="Ej: Aventura, RPG, Shooter" type="text" /></div>
      </div>         
   </div>
</div>
<div class="caja big">
   <h2>Requisitos del sistema</h2>
   <div class="form-group">
      <p class="form-label">Requirimientos para correrlo bien!</p>
      <div class="row">
         <div class="col-sm-6">
            <h4>Reqisitos mínimos</h4>
            <input id="os1" class="form-input mb-2" placeholder="Sistema Operativo" type="text" />
            <input id="procesador1" class="form-input mb-2" placeholder="Procesador" type="text" />
            <input id="memoriaram1" class="form-input mb-2" placeholder="Memoria Ram" type="text" />
            <input id="graficos1" class="form-input mb-2" placeholder="Gráficos" type="text" />
            <input id="almacenamiento1" class="form-input mb-2" placeholder="Almacenamiento" type="text" />
            <input id="direcxt1" class="form-input mb-2" placeholder="Direcxt (11, 12)" type="text" />
         </div>
         <div class="col-sm-6">
            <h4>Recomendados</h4>
            <input id="os2" class="form-input mb-2" placeholder="Sistema Operativo" type="text" />
            <input id="procesador2" class="form-input mb-2" placeholder="Procesador" type="text" />
            <input id="memoriaram2" class="form-input mb-2" placeholder="Memoria Ram" type="text" />
            <input id="graficos2" class="form-input mb-2" placeholder="Gráficos" type="text" />
            <input id="almacenamiento2" class="form-input mb-2" placeholder="Almacenamiento" type="text" />
            <input id="direcxt2" class="form-input mb-2" placeholder="Direcxt (11, 12)" type="text" />
         </div>
      </div>         
   </div>
</div>
<!-- FINAL -->
<div class="caja">
   <h2>Imágenes (Máximo 3)</h2>
   <div class="form-group">
      <p class="form-label">Agrega la url de las imagenes que quieras, pero todos los links separados con un <b>;</b> <i>(punto-coma)</i></p> 
      <textarea id="slideimg" class="form-input" placeholder="ej: imagen1.jpg; imagen2.png; imagen3.gif"></textarea>
   </div>
</div>
<div class="caja">
   <h2>Video de Youtube / Trailer</h2>
   <div class="form-group">
      <p class="form-label">Copiar el ID del video de Youtube <strong>Ejemplo:</strong> zUCisCpTPQw</p>
      <input id="youtube" class="form-input" placeholder="zUCisCpTPQw" maxlength="200" size="45" type="text" />
   </div>
</div>
<div class="caja big">
   <h2>Links de Descargas</h2>
   <div class="form-group">
      <p class="form-label">Coloca todos los links de descarga del archivo, pero todos los links separados con un <b>;</b> <i>(punto-coma)</i></p>
      <textarea id="downlinks" placeholder="ej: enlace1.com; enlace2.net; enlace3.org" class="form-input"></textarea>
   </div>
</div>
<div class="caja">
   <h2>Contraseña de Archivos</h2>
   <div class="form-group space">
      <p class="form-label">Pon la contraseña de los archivos que vas a compartir con los usuarios.</p>
      <input id="password" class="form-input" type="text" />
   </div>
</div>
