<div class="frame-form bg-light-subtle rounded position-relative overflow-hidden">
   <!-- Mostraremos esto para comprobar que va a publicar -->
   <div class="position-absolute zIndex-100 w-100 h-100 bg-loader-status top-0 start-0 d-none justify-content-center align-items-center flex-column text-white h5" id="loaderStatus"><span class=""><iconify-icon class="fs-3" icon="eos-icons:loading"></iconify-icon></span> Publicando...</div>
   <div class="muro-stream d-flex">
      <a class="py-1 px-3 d-flex justify-content-start gap-2 align-items-center" href="javascript:muro.stream.load('status', this)" id="stMain"><iconify-icon class="pe-none" icon="la:book-{if $tsInfo.uid == $tsUser->uid}open{else}reader{/if}"></iconify-icon> Estado</a>
      <a class="py-1 px-3 d-flex justify-content-start gap-2 align-items-center" href="javascript:muro.stream.load('foto', this)"><iconify-icon class="pe-none" icon="la:image-solid"></iconify-icon> Foto</a>
      <a class="py-1 px-3 d-flex justify-content-start gap-2 align-items-center" href="javascript:muro.stream.load('enlace', this)"><iconify-icon class="pe-none" icon="la:link"></iconify-icon> Enlace</a>
      <a class="py-1 px-3 d-flex justify-content-start gap-2 align-items-center" href="javascript:muro.stream.load('video', this)"><iconify-icon class="pe-none" icon="la:video"></iconify-icon> Video</a>
   </div>
   <div class="p-2">
      <div id="adjuntar" class="input-group"></div>
      <textarea class="status text-start form-control" id="wall" data-info-uid="{$tsInfo.uid}" data-uid="{$tsUser->uid}" placeholder="{if $tsInfo.uid == $tsUser->uid}&iquest;Qu&eacute; est&aacute;s pensando?{else}Escribe algo....{/if}"></textarea>
      <input type="button" class="btn btn-success shareBtn mt-2" value="Compartir" onclick="muro.stream.compartir();" />
   </div>
   <div id="preview"></div>
</div>
{*<div class="frameForm bg-light-subtle rounded p-3 mb-3 position-relative overflow-hidden">
   <!-- Mostraremos esto para comprobar que va a publicar -->
   <div class="position-absolute zIndex-100 w-100 h-100 bg-loader-status top-0 start-0 d-none justify-content-center align-items-center flex-column text-white h5" id="loaderStatus"><span class=""><iconify-icon class="fs-3" icon="eos-icons:loading"></iconify-icon></span> Publicando...</div>
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
                  <a href="javascript:muro.stream.load('status', this)" id="stMain">{if $tsInfo.uid == $tsUser->uid}<iconify-icon class="fs-3" icon="la:book-open"></iconify-icon>{else}<<iconify-icon class="fs-3" icon="la:book-reader"></iconify-icon>{/if}</a>
                  <a href="javascript:muro.stream.load('foto', this)"><iconify-icon class="fs-3" icon="la:image-solid"></iconify-icon></a>
                  <a href="javascript:muro.stream.load('enlace', this)"><iconify-icon class="fs-3" icon="la:link"></iconify-icon></a>
                  <a href="javascript:muro.stream.load('video', this)"><iconify-icon class="fs-3" icon="la:video"></iconify-icon></a>
               </div>
               <input type="button" class="btn btn-success shareBtn" value="Compartir" onclick="muro.stream.compartir();" />
            </div>
            
         </div>
      </div>
   </ul>
</div>*}