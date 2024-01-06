
   <div class="caja">
      <h2>Titulo del Post (Descriptivo)</h2>
      <div class="form-group">
         <p class="form-label">Que describa completamente el aporte que quieras mostrar a todos los usuarios</p>
         <input id="titulo" maxlength="200" size="45" class="form-input" type="text" />
      </div>
   </div>
   <div class="caja">
      <h2>Imágen Principal</h2>
      <div class="form-group">
         <p class="form-label">Actuara como imagen principal de tu Post, como una portada del aporte</p>
         <input id="portada" maxlength="200" size="45" class="form-input" type="text" />
      </div>
   </div>
   <div class="caja big">
      <h2>Información / Sipnosis / Descripción</h2>
      <div class="form-group">
         <textarea id="contenent_body" style="height:100px" class="form-input"></textarea>
      </div>
   </div>
   <!-- PARA JUEGOS -->
   <div class="caja big games" style="display:none;">
      <h2>Ficha técnica</h2>
      <div class="form-group">
         <p class="form-label">Información del archivo</p>
         <div class="row">
            <div class="col-sm-4 mb-3"><input id="plataforma" class="form-input" placeholder="ej: Pc, PS2, etc" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="pesototal" class="form-input" placeholder="ej: 8GB" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="formato" class="form-input" placeholder="ej: ISO, RAR, EXE, etc" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="idiomas" class="form-input" placeholder="Es, En, Ru" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="fechaestreno" class="form-input" placeholder="Fecha de estreno (dd/mm/aaaa)" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="fechaactualizacion" class="form-input" placeholder="Fecha de actualización (dd/mm/aaaa)" type="text" /></div>
            <div class="col-sm-12"><input id="generosg" class="form-input" placeholder="Ej: Aventura, RPG, Shooter" type="text" /></div>
         </div>         
      </div>
   </div>
   <div class="caja big games" style="display:none;">
      <h2>Requisitos del sistema</h2>
      <div class="form-group">
         <p class="form-label">Requirimientos para correrlo bien!</p>
         <div class="row">
            <div class="col-sm-6">
               <h4>Reqisitos mínimos</h4>
               <input id="os1" class="form-input mb-2" placeholder="Sistema Operatico" type="text" />
               <input id="procesador1" class="form-input mb-2" placeholder="Procesador" type="text" />
               <input id="memoriaram1" class="form-input mb-2" placeholder="Memoria Ram" type="text" />
               <input id="graficos1" class="form-input mb-2" placeholder="Gráficos" type="text" />
               <input id="almacenamiento1" class="form-input mb-2" placeholder="Almacenamiento" type="text" />
               <input id="direcxt1" class="form-input mb-2" placeholder="Direcxt (11, 12)" type="text" />
            </div>
            <div class="col-sm-6">
               <h4>Recomendados</h4>
               <input id="os2" class="form-input mb-2" placeholder="Sistema Operatico" type="text" />
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
   <!-- PARA PELICULAS -->
   <div class="caja big movies" style="display:none;">
      <h2>Información adicional</h2>
      <div class="form-group">
         <p class="form-label">Información sobre duración, estreno, generos, calidad, etc</p>
         <div class="row">
            <div class="col-sm-4 mb-3"><input id="duracion" class="form-input" placeholder="1:40 hs" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="estreno" class="form-input" placeholder="(dia) de (mes) del (año)" type="text" /></div>
            <div class="col-sm-4 mb-3"><input id="generos" class="form-input" placeholder="ej: accion, terror, suspenso, etc" type="text" /></div>
            <div class="col-sm-6"><input id="calidad" class="form-input" placeholder="HD, 4K, AVI, etc" type="text" /></div>
            <div class="col-sm-6"><input id="audio" class="form-input" placeholder="Castellano, Español, Inglés, etc" type="text" /></div>
         </div>         
      </div>
   </div>
   <!-- FINAL -->
   <div class="caja">
      <h2>Imágenes (Máximo 3)</h2>
      <div class="form-group">
         <p class="form-label">Agrega la url de las imagenes que quieras, pero todos los links separados con un <b>;</b> <i>(punto-coma)</i></p> 
         <textarea id="slideimg" class="form-input" placeholder="ej: enlace1.com; enlace2.net; enlace3.org"></textarea>
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
      <h2>Links de Descargas / Servidores de descargas</h2>
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

   