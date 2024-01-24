<div class="my-3 mb-1 border-top border-bottom py-3 text-uppercase text-center">
	<h3 class="m-0">Administrar SEO</h3>
</div>
<form name="confSeo">
	<div class="row">

		<div class="col-12 col-md-6">
			<div class="form-group">
				<label class="form-label" for="titulo">Titulo del sitio</label>
				<input type="text" name="titulo" id="titulo" value="{$tsAdmSeo.titulo}" class="form-control">
				<small class="d-block">Debe contener entre 50 a 60 caracteres!</small>
			</div>
			<div class="form-group">
				<label class="form-label" for="portada">Imagen que se verá al compatir el sitio</label>
				<input type="text" name="portada" id="portada" value="{$tsAdmSeo.portada}" class="form-control">
			</div>
			<div class="form-group">
				<label class="form-label" for="favicon">Url para imagen del favicon</label>
				<input type="text" name="favicon" id="favicon" value="{$tsAdmSeo.favicon}" class="form-control">
			</div>
			<div class="form-group">
				<label class="form-label" for="color">Color para la web</label>
				<input type="color" name="color" id="color" value="{$tsAdmSeo.color}" class="form-control">
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
				<input type="text" name="app_fb" id="appfb" value="{$tsAdmSeo.app_fb}" class="form-control">
			</div>
			<div class="form-group">
				<label class="form-label" for="twuser">Usuario de twitter (página)</label>
				<input type="text" name="tw_page" id="twuser" value="{$tsAdmSeo.tw_page}" class="form-control">
			</div>
		</div>

		<div class="col-12 col-md-6">
			<div class="form-group">
				<label class="form-label" for="descripcion">Descripción</label>
				<textarea name="descripcion" id="descripcion" rows="5" class="form-control">{$tsAdmSeo.descripcion}</textarea>
				<small class="d-block">Debe contener entre 150 a 160 caracteres!</small>
			</div>
			<div class="form-group">
				<label class="form-label" for="keywords">Palabras claves</label>
				<textarea name="keywords" id="keywords" rows="5" class="form-control">{$tsAdmSeo.keywords}</textarea>
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
				  <small>indica a los buscadores que no muestren esa página en los resultados de búsqueda.</small>
				</div>
			</div>
			
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