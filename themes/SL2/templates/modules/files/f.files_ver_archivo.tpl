{if $tsFile.data.f_ext == 'jpg' || $tsFile.data.f_ext == 'gif' || $tsFile.data.f_ext == 'png' || $tsFile.data.f_ext == 'bmp' || $tsFile.data.f_ext == 'mp3' || $tsFile.data.f_ext == 'mp4' || $tsFile.data.f_ext == 'avi' || $tsFile.data.f_ext == 'wmv' || $tsFile.data.f_ext == 'flv' || $tsFile.data.f_ext == 'mkv' || $tsFile.data.f_ext == 'mpg' || $tsFile.data.f_ext == '3gp' || $tsFile.data.f_ext == 'txt' || $tsFile.data.f_ext == 'pdf' || $tsFile.data.f_ext == 'swf' || $tsFile.data.f_ext == 'html'}
	
   <!-- IMAGENES -->
   {if $tsFile.data.f_ext == 'jpg' || $tsFile.data.f_ext == 'gif' || $tsFile.data.f_ext == 'png' || $tsFile.data.f_ext == 'bmp'}
   <div class="text-center">
      <img src="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}" style="max-width:100%;min-width:20%;margin:10px auto;" />
   </div>
   <!-- MUSICA -->
   {elseif $tsFile.data.f_ext == 'mp3'}
      <div class="mb-2">
         <span class="d-block">Titulo original: <b>{$tsMp3Info.0}</b></span>
         <span class="d-block">Duración: <b>{$tsMp3Info.1}</b></span>
         <span class="d-block">KBPS: <b>{$tsMp3Info.2}</b>kb/s</span>
         <span class="d-block">Channel: <b>{$tsMp3Info.3}</b></span>
      </div>   
      <audio controls class="w-100 m-2">
         <source src="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}" type="audio/mp3">
         Su navegador no es compatible con el elemento de audio.
      </audio>      
   <!-- VIDEO -->
   {elseif $tsFile.data.f_ext == 'mp4' || $tsFile.data.f_ext == 'avi' || $tsFile.data.f_ext == 'wmv' || $tsFile.data.f_ext == 'flv' || $tsFile.data.f_ext == 'mkv' || $tsFile.data.f_ext == 'mpg' || $tsFile.data.f_ext == '3gp'}
      <video controls="controls" src="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}" type="video/mp4" style="width: 650px;"></video>
   <!-- SWF -->
   {elseif $tsFile.data.f_ext == 'swf'}
      <object width="650" height="450">
         <param name="movie" id="movie" value="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}">
         <param name="quality" value="high">
         <embed src="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="650" height="450"></embed>
       </object>
   <!-- TEXTOS -->
   {elseif $tsFile.data.f_ext == 'pdf'}
      <embed src="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}#toolbar=0&view=fitH,100" type="application/{$tsFile.data.f_ext}" width="100%" class="w-100 my-2" height="600px" />
   <!-- TEXTOS -->
   {elseif $tsFile.data.f_ext == 'txt'}
      <div class="p-2" style="height:500px;">
         {foreach $tsInfoFile item=txt key=i}
            {$txt}<br>
         {/foreach}
      </div>
   <!-- DOCUMENTOS MICROSOFT WINDOWS -->
   {elseif $tsFile.data.f_ext == 'html'}
      <iframe src="{$tsConfig.url}/files/archivos/{$tsFile.data.f_url}" class="w-100" id="iframeID" style="border:0" height="600px"></iframe>
      <script> $('#iframeID').contents().find('body').html(); </script>
   {/if}

   <!-- SI NO SE CONOCE EL ARCHIVO  -->  
{else}
   <div class="File_format d-flex justify-content-center align-items-center">
      <i data-feather="file"></i>
      <span>{$tsFile.data.f_ext}</span>
   </div>    
{/if}
<style>
.File_format {
   position: relative;
   width: 220px;
   height: 220px;
   margin: 10px auto;
}
.File_format .featherIcons {
   width: 220px;
   height: 220px;
   stroke: #222;
   stroke-width: 1px; 
}
.File_format span {
   position: absolute;
   font-size: 30px;
   font-weight: 700;
   text-transform: uppercase;
   color: #444;
   right: 55px;
   bottom: 28px;
}
</style>