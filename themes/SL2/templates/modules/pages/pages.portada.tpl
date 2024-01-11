{assign "unsplash" "https://unsplash.com/"}
{assign "pexels" "https://www.pexels.com/es-es/"}
<div class="container">
   <div class="box-lateral">
      <h2 class="box-header">¿Com&oacute; cambiar portada/header?</h2>
      <div class="box-body lead">
         <p>Para cambiar la portada es bastante f&aacute;cil, primero deben seleccionar entre <b><a class="text-primary" title="Ir a unsplash" target="_blank" href="{$unsplash}">Unsplash</a></b> y <b><a class="text-primary" title="Ir a pexels" target="_blank" href="{$pexels}">Pexels</a></b>, una vez que decidan cual usar acceden a la p&aacute;gina correspondiente:</p>
         <ul class="ms-4 my-3">
            <li><a class="text-primary fw-bold" title="Ir a pexels" target="_blank" href="{$pexels}">Pexels</a></li>
            <li><a class="text-primary fw-bold" title="Ir a unsplash" target="_blank" href="{$unsplash}">Unsplash</a></li>
         </ul>
         <p>Ahora lo que deben hacer es buscar una imagen que a ustedes les guste bastante, le dan un clic y se abrir&aacute; el modal para descargar la imagen, pero no lo har&aacute;n... En la url solo copian la ID<i class="text-danger">(texto rojo)</i> de dicha imagen.</p>
         <p class="my-1 mx-2 text-secondary">Ejemplo <b>Unsplash</b>: {$unsplash}photos/<b class="text-danger">B7KmlY_8Y9w</b></p>
         <p class="my-1 mx-2 text-secondary">Ejemplo <b>Pexels</b>: {$pexels}foto/adentro-apple-dispositivos-escritorio-<b class="text-danger">326504</b>/</p>
         <p>Lo copian y lo pengan en el campo que dice "<b>ID de image</b>", es todo lo que hay que saber, luego solo para la imagenes de pexels pueden usar par&aacute;metros. Para ambos pueden definir el tama&ntilde;o de la imagen para que se adapte a ustedes.</p>
      </div>
   </div>
</div>