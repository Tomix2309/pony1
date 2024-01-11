{if $tsUser->is_admod == 1}
<div class="hero">
   <div class="hero-body">
      <h1>Sistema de control de la web</h1>
      <p>En esta página se podrá hacer configuraciones para el aspecto de la web, el nombre e id se guardará en el caché de tu navegador, para así de esta forma poder localizar el archivo de configuración y asi cada usuario tendrá su propio estilo.</p>
   </div>
</div>

<div class="alert alert-dark mt-3 mb-1"><h3 class="m-0">Administrar SEO</h3></div>
<form name="confSeo">
   <div class="row">

      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="titulo">Titulo del sitio</label>
            <input type="text" name="titulo" id="titulo" value="{$tsAdmSeo.titulo}" class="form-input">
            <small class="d-block">Debe contener entre 50 a 60 caracteres!</small>
         </div>
         <div class="form-group">
            <label class="form-label" for="portada">Imagen que se verá al compatir el sitio</label>
            <input type="text" name="portada" id="portada" value="{$tsAdmSeo.portada}" class="form-input">
         </div>
         <div class="form-group">
            <label class="form-label" for="favicon">Url para imagen del favicon</label>
            <input type="text" name="favicon" id="favicon" value="{$tsAdmSeo.favicon}" class="form-input">
         </div>
         <div class="form-group">
            <label class="form-label" for="color">Color para la web</label>
            <input type="color" name="color" id="color" value="{$tsAdmSeo.color}" class="form-color">
         </div>
         <div class="form-group">
            <label class="form-label" for="images">Agrega más imagenes para el seo</label>
            {foreach $tsAdmSeo.seo_images_total key=i item=px}
               <div class="input-group mb-3">
                  <span class="input-group-text" id="pixeles">{$px}x{$px}</span>
                  <input class="form-control" type="text" id="images" name="images[{$px}]" value="{$tsAdmSeo.images.$px}" />
                  <button type="button" class="btn btn-primary" onclick="$(this).parent().remove()">Quitar</button>
               </div>
            {/foreach}
         </div>
         <div class="form-group">
            <label class="form-label" for="appfb">App id Facebook</label>
            <input type="text" name="app_fb" id="appfb" value="{$tsAdmSeo.app_fb}" class="form-input">
         </div>
         <div class="form-group">
            <label class="form-label" for="twuser">Usuario de twitter (página)</label>
            <input type="text" name="tw_page" id="twuser" value="{$tsAdmSeo.tw_page}" class="form-input">
         </div>
      </div>

      <div class="col-12 col-md-6">
         <div class="form-group">
            <label class="form-label" for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="5" class="form-input">{$tsAdmSeo.descripcion}</textarea>
            <small class="d-block">Debe contener entre 150 a 160 caracteres!</small>
         </div>
         <div class="form-group">
            <label class="form-label" for="keywords">Palabras claves</label>
            <textarea name="keywords" id="keywords" rows="5" class="form-input">{$tsAdmSeo.keywords}</textarea>
         </div>
         <div class="form-group">
            <label class="form-label" for="robots">Activar rasteadores</label>
            {html_radios_custom name="robots" values=[1, 0] id="robots" output=['Si', 'No'] selected=$tsAdmSeo.robots}
            <small>Activar los rastreadores de los motores de búsqueda si pueden o no indexar una página</small>
         </div>
         <div class="form-group">
            <label class="form-label" for="robots_name">Tipos de rasteadores</label>
            <div class="mb-3">
              <div class="input-group">
                 <label class="input-group-text" for="robots_name">Name</label>
                 {html_options name='robots_data[name]' id='robots_name' options=[0 => 'robots', 1 => 'googlebot', 2 => 'googlebot-news'] selected=$tsAdmSeo.robots_name class="form-select"}
              </div>
            </div>
            <div class="mb-3">
              <div class="input-group">
                 <label class="input-group-text" for="robots_name">Content</label>
                 {html_options name='robots_data[content]' id='robots_content' options=[0 => 'index', 1 => 'follow', 2 => 'noindex', 3 => 'nofollow', 4 => 'nosnippet', 5 => 'index, follow', 6 => 'index, nofollow', 7 => 'noindex, follow', 8 => 'noindex, nofollow'] selected=$tsAdmSeo.robots_content class="form-select"}
              </div>
            </div>
         </div>
         <small>indica a los buscadores que no muestren esa página en los resultados de búsqueda.</small>
      </div>
   </div>
   <div class="search-results">
      <div class="result">
         <img class="rounded image mb-3" src="{$tsAdmSeo.portada}" alt="{$tsAdmSeo.titulo}">
         <span class="title text-primary">{$tsAdmSeo.titulo}</span><br>
         <span class="url fst-italic">{$tsConfig.url}</span><br>
         <p class="descripcion m-0 p-0">{$tsAdmSeo.descripcion}</p>
      </div>
   </div>
   <style>
      .search-results {
         width: 600px;
         margin: 1rem auto;
         padding: 1rem;
         border: 1px solid var(--bs-gray-900);
         border-radius: 5px;
         background-color: var(--bs-white);
      }
     .title { font-size: 18px; font-weight: bold; }
     .url { color: #006621; }
     .descripcion { color: #545454; }
     .image { width: 100%;object-fit: cover; }
   </style>
</form>
<p class="text-right mb-2">
   <a href="javascript:guardar.seo()" class="btn btn-primary">Guardar SEO</a>
</p>

<!-- Administración del header -->
<div class="alert alert-dark mt-3 mb-1"><h3 class="m-0">Administrar header</h3></div>
<form name="confHeader">
   <div class="row">
      <div class="col-6">
         <h4 class="bg-light py-1 px-2 m-0">Imágen</h4>
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label class="form-label">Página</label>
                  <div>
                     <label class="form-radio d-inline-block">
                        <input type="radio" value="pexels" name="type"{if $tsAdmInfo.web == 'pexels'} checked{/if}>
                        <i class="form-icon"></i> Pexels
                     </label>
                     <label class="form-radio d-inline-block">
                        <input type="radio" value="unplash" name="type"{if $tsAdmInfo.web == 'unplash'} checked{/if}>
                        <i class="form-icon"></i> Unplash
                     </label>
                  </div>
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label class="form-label" for="portada">ID de imagen</label>
                  <input type="text" name="id" id="portada" value="{$tsAdmInfo.id}" class="form-input">
               </div>
            </div>
         </div>
      </div>
      <div class="col-6">
         <!-- Tamaño de la imagen -->
         <h4 class="bg-light py-1 px-2 m-0">Tamaño</h4>
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label class="form-label" for="width">Anchura de la imagen</label>
                  <input type="number" name="width" id="width" value="{$tsAdmInfo.width}" class="form-input">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label class="form-label" for="height">Altura de la imagen</label>
                  <input type="number" name="height" id="height" value="{$tsAdmInfo.height}" class="form-input">
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Asignamos los estilos para la portada -->
   <h4 class="bg-light py-1 px-2 m-0">Estilos CSS</h4>
   <div class="row">
      <div class="col-3">
         <div class="form-group">
            <label class="form-label" for="posicion">Posición de la imagen</label>
            <select id="posicion" class="form-select" name="position">
               <option value="left top"{if $tsAdmInfo.position == "left top"} selected{/if}>Left top</option>
               <option value="left center"{if $tsAdmInfo.position == "left center"} selected{/if}>Left center</option>
               <option value="left bottom"{if $tsAdmInfo.position == "left bottom"} selected{/if}>Left bottom</option>
               <option value="right top"{if $tsAdmInfo.position == "right top"} selected{/if}>Right top</option>
               <option value="right center"{if $tsAdmInfo.position == "right center"} selected{/if}>Right center</option>
               <option value="right bottom"{if $tsAdmInfo.position == "right bottom"} selected{/if}>Right bottom</option>
               <option value="center top"{if $tsAdmInfo.position == "center top"} selected{/if}>Center top</option>
               <option value="center center"{if $tsAdmInfo.position == "center center"} selected{/if}>Center center</option>
               <option value="center bottom"{if $tsAdmInfo.position == "center bottom"} selected{/if}>Center bottom</option>
            </select>
            <small class="text-muted">Referencias en w3schools:<a class="fw-bold d-block text-primary" href="https://www.w3schools.com/cssref/pr_background-position.asp" target="_blank">background-position</a></small>
         </div>
      </div>
      <div class="col-3">
         <div class="form-group">
            <label class="form-label" for="repetir">Repetir la imagen</label>
            <select id="repetir" class="form-select" name="repeat">
               <option value="repeat"{if $tsAdmInfo.repeat == "repeat"} selected{/if}>Repeat</option>
               <option value="repeat-x"{if $tsAdmInfo.repeat == "repeat-x"} selected{/if}>Repeat-x</option>
               <option value="repeat-y"{if $tsAdmInfo.repeat == "repeat-y"} selected{/if}>Repeat-y</option>
               <option value="no-repeat"{if $tsAdmInfo.repeat == "no-repeat"} selected{/if}>No-repeat</option>
            </select>
            <small class="text-muted">Referencias en w3schools:<a class="fw-bold d-block text-primary" href="https://www.w3schools.com/cssref/pr_background-repeat.asp" target="_blank">background-repeat</a></small>
         </div>
      </div>
      <div class="col-3">
         <div class="form-group">
            <label class="form-label" for="fijar">Desplazar imagen</label>
            <select id="fijar" class="form-select" name="attachment">
               <option value="scroll"{if $tsAdmInfo.attachment == "scroll"} selected{/if}>Scroll</option>
               <option value="fixed"{if $tsAdmInfo.attachment == "fixed"} selected{/if}>Fixed</option>
               <option value="local"{if $tsAdmInfo.attachment == "local"} selected{/if}>Local</option>
               <option value="initial"{if $tsAdmInfo.attachment == "initial"} selected{/if}>Initial</option>
               <option value="inherit"{if $tsAdmInfo.attachment == "inherit"} selected{/if}>Inherit</option>
            </select>
            <small class="text-muted">Referencias en w3schools:<a class="fw-bold d-block text-primary" href="https://www.w3schools.com/cssref/pr_background-attachment.asp" target="_blank">background-attachment</a></small>
         </div>
      </div>
      <div class="col-3">
         <div class="form-group">
            <label class="form-label" for="size">Tamaño imagen</label>
            <input type="text" name="size" id="size" value="{$tsAdmInfo.size}" class="form-input">
            <small class="text-muted">Referencias en w3schools:<a class="fw-bold d-block text-primary" href="https://www.w3schools.com/cssref/css3_pr_background-size.asp" target="_blank">background-size</a></small>
         </div>
      </div>
   </div>
</form>
<p class="text-right">
   <a href="javascript:guardar.header()" class="btn btn-primary">Guardar Header</a>
</p>
<script src="{$tsConfig.js}/settings.js?{$smarty.now}"></script>
{else}
<div class="hero">
   <div class="hero-body">
      <h1>Que haces?</h1>
      <p>Tú no tienes permitido ver esta sección, bueno si la ves, pero no puedes hacer nada a no ser que seas administrador</p>
   </div>
</div>
{/if}