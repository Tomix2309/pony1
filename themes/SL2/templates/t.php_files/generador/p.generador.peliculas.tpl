<div class="caja big">
   <h2>Sinopsis</h2>
   <div class="form-group">
      <textarea id="contenent_body" data-type="Sinopsis" style="height:100px" class="form-input"></textarea>
   </div>
</div>
<!-- PARA PELICULAS -->
<div class="caja big movies">
   <h2>Información adicional</h2>
   <div class="form-group">
      <p class="form-label">Información sobre duración, estreno, generos, calidad, etc</p>
      <div class="row">
         <div class="col-sm-4 mb-3"><input id="duracion" data-type="Duración" class="form-input" placeholder="1:40 hs" type="text" /></div>
         <div class="col-sm-4 mb-3"><input id="estreno" data-type="Estreno" class="form-input" placeholder="(dia) de (mes) del (año)" type="text" /></div>
         <div class="col-sm-4 mb-3"><input id="generos" data-type="Géneros" class="form-input" placeholder="ej: accion, terror, suspenso, etc" type="text" /></div>
         <div class="col-sm-6"><input id="calidad" data-type="Calidad" class="form-input" placeholder="HD, 4K, AVI, etc" type="text" /></div>
         <div class="col-sm-6"><input id="audio" data-type="Audio" class="form-input" placeholder="Castellano, Español, Inglés, etc" type="text" /></div>
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
   <h2>Trailer</h2>
   <div class="form-group">
      <p class="form-label">Copiar el ID del video de Youtube <strong>Ejemplo:</strong> zUCisCpTPQw</p>
      <input id="youtube" class="form-input" placeholder="zUCisCpTPQw" maxlength="200" size="45" type="text" />
   </div>
</div>
<div class="caja big">
   <h2>Servidores de descargas</h2>
   <div class="form-group">
      <p class="form-label">Coloca todos los links de descarga del archivo, pero todos los links separados con un <b>;</b> <i>(punto-coma)</i></p>
      <textarea id="downlinks" placeholder="ej: enlace1.com; enlace2.net; enlace3.org" class="form-input"></textarea>
   </div>
</div>
