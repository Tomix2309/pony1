<div class="frameForm bg-white rounded p-3 mb-3 position-relative overflow-hidden">
   <!-- Mostraremos esto para comprobar que va a publicar -->
   <div class="position-absolute zIndex-100 w-100 h-100 bg-loader-status top-0 left-0 d-none justify-content-center align-items-center flex-column text-white h5" id="loaderStatus"><span class="loading-icon"><i data-feather="aperture"></i></span> Publicando...</div>
   <ul class="options" id="publicar">
      <div class="attaFrame">
         <div id="attaContent">
            <div id="statusFrame">
               <textarea class="status form-input" id="wall" onfocus="onfocus_input(this)" onblur="onblur_input(this)" placeholder="{if $tsInfo.uid == $tsUser->uid}&iquest;Qu&eacute; est&aacute;s pensando?{else}Escribe algo....{/if}"></textarea>
            </div>
            <div id="fotoFrame">
               <input type="text" class="form-input" name="ifoto" placeholder="{$tsConfig.url}/images/ejemplo.jpg" onfocus="onfocus_input(this)" onblur="onblur_input(this)"/>
               <a href="#" class="btn btn-success adj" onclick="muro.stream.adjuntar(); return false;">Adjuntar</a>
            </div>
            <div id="enlaceFrame">
               <input type="text" class="form-input" name="ienlace" placeholder="{$tsConfig.url}/blog/ejemplo.html" onfocus="onfocus_input(this)" onblur="onblur_input(this)"/>
               <a href="#" class="btn btn-success adj" onclick="muro.stream.adjuntar(); return false;">Adjuntar</a>
            </div>
            <div id="videoFrame">
               <input type="text" class="form-input" name="ivideo" placeholder="http://www.youtube.com/watch?v=f_30BAGNqqA" onfocus="onfocus_input(this)" onblur="onblur_input(this)"/>
               <a href="#" class="btn btn-success adj" onclick="muro.stream.adjuntar(); return false;">Adjuntar</a>
            </div>
         </div>
         <div class="attaDesc">
            <div class="wrap">
               <textarea class="status form-input" id="attaDesc" onfocus="onfocus_input(this)" onblur="onblur_input(this)" placeholder="Haz un comentario sobre esta foto..."></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
               <div class="muro-stream d-flex justify-content-start align-items-center">
                  <a href="#" class="" onclick="muro.stream.load('status', this); return false;" id="stMain">{if $tsInfo.uid == $tsUser->uid}<i data-feather="book-open"></i>{else}<i data-feather="edit"></i>{/if}</a>
                  <a href="#" class="" onclick="muro.stream.load('foto', this); return false;"><i data-feather="camera"></i></a>
                  <a href="#" class="" onclick="muro.stream.load('enlace', this); return false;"><i data-feather="link"></i></a>
                  <a href="#" class="" onclick="muro.stream.load('video', this); return false;"><i data-feather="play"></i></a>
               </div>
               <input type="button" class="btn btn-success shareBtn" value="Compartir" onclick="muro.stream.compartir();" />
            </div>
            
         </div>
      </div>
   </ul>
</div>