<script src="https://cdn.jsdelivr.net/npm/code-prettify@0.1.0/loader/run_prettify.min.js"></script>
<link rel="stylesheet" href="https://jmblog.github.io/color-themes-for-google-code-prettify/themes/atelier-estuary-dark.min.css">
{if $permitidos}
	
   <!-- IMAGENES -->
   {if in_array($tsArchivo.data.arc_ext, $tsDatos.images)}
      <div class="text-center">
         <img src="{$tsArchivo.data.url_file}" style="max-width:100%;min-width:20%;margin:10px auto;" />
      </div>
   <!-- MUSICA -->
   {elseif $tsArchivo.data.arc_ext == 'mp3'}
      <div class="mb-2">
         <audio controls style="width: 100%;" class="p-2">
            <source src="{$tsArchivo.data.url_file}" type="audio/{$tsArchivo.data.arc_ext}">
            Tu navegador no soporta audio HTML5.
         </audio>
         <div class="d-block p-2">Titulo original: <strong class="d-block h3">{if empty($tsMp3Info.title)}{$tsArchivo.data.arc_name}{else}{$tsMp3Info.title}{/if}</strong></div>
         <div class="row">
            <div class="col">
               <div class="p-2">Duración: <strong class="d-block h3">{$tsMp3Info.duration}</strong></div>
            </div>
            <div class="col">
               <div class="p-2">KBPS: <strong class="d-block h3">{$tsMp3Info.kbps}kb/s</strong></div>
            </div>
            <div class="col">
               <div class="p-2">Canal: <strong class="d-block h3">{$tsMp3Info.channel}</strong></div>
            </div>
            <div class="col">
               <div class="p-2">Peso: <strong class="d-block h3">{$tsArchivo.data.arc_weight}</strong></div>
            </div>
         </div>
      </div>  
   <!-- VIDEO -->
   {elseif in_array($tsArchivo.data.arc_ext, $tsDatos.videos)}
      <video controls="controls" src="{$tsArchivo.data.url_file}" type="video/{$mime}" style="width: 650px;"></video>
   <!-- SWF -->
   {elseif $tsArchivo.data.arc_ext == 'swf'}
      <object width="650" height="450">
         <param name="movie" id="movie" value="{$tsArchivo.data.url_file}">
         <param name="quality" value="high">
         <embed src="{$tsArchivo.data.url_file}" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="650" height="450"></embed>
       </object>
   <!-- TEXTOS -->
   {elseif $tsArchivo.data.arc_ext == 'pdf'}
      <embed src="{$tsArchivo.data.url_file}" type="application/pdf" width="100%" height="600px">
   <!-- TEXTOS -->
   {elseif in_array($tsArchivo.data.arc_ext, $tsDatos.text)}
      <pre class="prettyprint">
         <code class="language-{$tsArchivo.data.arc_ext}">{$tsInfoFile}</code>
      </pre>
   <!-- DOCUMENTOS MICROSOFT WINDOWS -->
   {elseif $tsArchivo.data.arc_ext == 'html'}
      <iframe src="{$tsArchivo.data.url_file}" class="w-100" id="iframeID" style="border:0" height="600px"></iframe>
      <script> $('#iframeID').contents().find('body').html(); </script>
   {/if}

   <!-- SI NO SE CONOCE EL ARCHIVO  -->  
{else}
   <div class="File_format mx-auto my-3 d-flex justify-content-center align-items-center flex-column">
      <i data-feather="file-text"></i>
      <span class="fw-bold text-uppercase fs-3 text-center d-block">.{$tsArchivo.data.arc_ext}</span>
   </div>    
{/if}
<style>
.File_format {
   --size: 240px;
   position: relative;
   width: var(--size);
}
.File_format .featherIcons {
   width: var(--size);
   height: var(--size);
   stroke: var(--bs-dark-text-emphasis);
   stroke-width: 1px; 
}
.File_format span {
   color: var(--bs-dark-text-emphasis);
}
</style>