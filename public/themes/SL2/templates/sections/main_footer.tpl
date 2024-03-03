		<!--end-cuerpo-->
</div>
{if $tsMobile}
	{include "sections/footer_menu_mobile.tpl"}
{/if}
<!-- Contenido en espera -->
{if $tsUser->is_admod && $tsConfig.c_see_mod && $tsConfig.novemods.total}
<div id="stickymsg" class="position-fixed bottom-5 right-2 shadow-3 rounded p-2 bg-danger text-white"  data-url="{$tsConfig.url}/moderacion/">Hay {$tsConfig.novemods.total} contenido{if $tsConfig.novemods.total != 1}s{/if} esperando revisi&oacute;n</div>
{/if}
<footer class="container-fluid bg-dark-subtle">
	<div class="container mt-4">
		<div class="row">
			<div class="col-md-5 mb-3">
				<h5>Sobre nosotros!</h5>
				<p class="position-relative py-3 pr-2">
					<img src="{$tsConfig.images}/loadImage.gif" data-src="{$seo.seo_favicon}" alt="{$tsConfig.titulo}" style="width: 4rem;height: 4rem;" class="image avatar img-fit-cover rounded me-3 float-start">                
					<span id="descripcion">{$seo.seo_descripcion}</span>
				</p>
			</div>
			<div class="col-6 col-md-3 mb-3">
			  <h5>Información</h5>
			  <ul class="nav flex-column">
				 <li class="nav-item mb-2"><a href="{$tsConfig.url}/pages/protocolo/" class="nav-link p-0 text-body-secondary">Protocolo</a></li>
				 <li class="nav-item mb-2"><a href="{$tsConfig.url}/pages/dmca/" class="nav-link p-0 text-body-secondary">Report Abuse - DMCA</a></li>
				 <li class="nav-item mb-2"><a href="{$tsConfig.url}/pages/portada/" class="nav-link p-0 text-body-secondary">¿Como cambiar portada/header?</a></li>
				 <li class="nav-item mb-2"><a href="javascript:modechange()" class="nav-link p-0 text-body-secondary">Cambiar a <strong id="mode_change">{if $tsMode == 'dark'}light{else}dark{/if}</strong></a></li>
			  </ul>
			</div>
			{if $tsUser->is_member}
			<div class="col-6 col-md-3 mb-3">
				<h5>Otros enlaces</h5>
				<ul class="nav flex-column">
					{if $tsUser->is_admod}
						<li class="nav-item mb-2"><a href="{$tsConfig.url}/pages/settings/?tab=seo" class="nav-link p-0 text-body-secondary">Configurar Seo</a></li>
						<li class="nav-item mb-2"><a href="{$tsConfig.url}/pages/settings/?tab=header" class="nav-link p-0 text-body-secondary">Configurar Header</a></li>
					{/if}
					<li class="nav-item mb-2"><a href="{$tsConfig.url}/cuenta/" class="nav-link p-0 text-body-secondary">Configurar mi cuenta</a></li>
					<li class="nav-item mb-2"><a href="{$tsConfig.url}/cuenta/avatar" class="nav-link p-0 text-body-secondary">Cambiar avatar</a></li>
				</ul>
			</div>
			{/if}
		</div>
	</div>
	<div class="d-flex flex-wrap justify-content-between align-items-center pt-1 pb-3 mb-4 border-top">
		<p class="col-md-4 mb-0 text-body-secondary"><strong>{$tsConfig.titulo}</strong> © {$smarty.now|date_format:"Y"}<br><small>Powered by <a href="https://www.phpost.es/" class="text-body-secondary" rel="external" target="_blank"><strong>PHPost</strong></a> </small> - <small class="font-italic">Theme por <a class="fw-bold text-body-secondary" rel="external" target="_blank" href="https://phpost.es/user-23.html">Miguel92</a></small></p>
		<ul class="nav col-md-4 justify-content-end">
			<li class="nav-item"><a class="nav-link px-2 text-body-secondary" href="{$tsConfig.url}/pages/terminos-y-condiciones/">T&eacute;rminos & condiciones</a></li>
			<li class="nav-item"><a class="nav-link px-2 text-body-secondary" href="{$tsConfig.url}/pages/privacidad/">Privacidad de datos</a></li>
			<li class="nav-item"><a class="nav-link px-2 text-body-secondary" href="{$tsConfig.url}/sitemap.xml">Sitemap</a></li>
			<li class="nav-item"><a class="av-link px-2" href="https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.es" target="_blank" title="CC BY-NC-SA"><img src="https://licensebuttons.net/l/by-nc-sa/3.0/88x31.png" alt="Licencia Creative Common"></a></li>
		</ul>
	</div>
</footer>

{jsdelivr type="js" files=['bootstrap','feather','iconify','driver','lazyload','croppr','pace']}
{hook js=['script.js'] position="end"}

</body>
</html>