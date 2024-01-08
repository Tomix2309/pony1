      <!--end-cuerpo-->
</div>
{if $tsMobile}
   {include "sections/footer_menu_mobile.tpl"}
{/if}
<footer class="pb-4 pt-2">
   <div class="container">
      <div class="row columnas">
         <div class="col-12 col-md-6">
            <h3 class="m-0 p-2 mt-3 mb-2">Sobre nosotros!</h3>
            <p class="position-relative py-3 pr-2 fw-bold">
               {image type="foto" alt="{$tsConfig.titulo}" src="{$tsImagenDes}" class="rounded img-fit-cover mr-3 float-start"}
               {$tsFooterDes}
            </p>
         </div>
         <div class="col-12 col-sm-6 col-md-3">
            <h3 class="m-0 p-2 mt-3 mb-2">Información</h3>
            <ul class="list-unstyled">
               <li><a class="text-dark fw-bold" href="{$tsConfig.url}/pages/protocolo/">Protocolo</a></li>
               <li><a class="text-dark fw-bold" href="{$tsConfig.url}/pages/dmca/">Report Abuse - DMCA</a></li>
               <li><a class="text-dark fw-bold" href="{$tsConfig.url}/pages/portada/">¿Como cambiar portada/header?</a></li>
            </ul>
         </div>
         <div class="col-12 col-sm-6 col-md-3">
            <h3 class="m-0 p-2 mt-3 mb-2">Más enlaces</h3>
            <ul class="list-unstyled">
               {if $tsUser->is_admod}
               <li><a class="text-dark fw-bold" href="{$tsConfig.url}/pages/settings/">Configurar sitio</a></li>
               {/if}
               <li><a class="text-dark fw-bold" href="{$tsConfig.url}/cuenta/">Configurar mi cuenta</a></li>
            </ul>
         </div>
      </div>
      <hr>
      <div class="footdown d-md-flex d-flex justify-content-between align-items-center">
         <div class="list-footer-down">
            <a href="{$tsConfig.url}/pages/terminos-y-condiciones/">T&eacute;rminos & condiciones</a> &bull; 
            <a href="{$tsConfig.url}/pages/privacidad/">Privacidad de datos</a> &bull; 
            <a href="{$tsConfig.url}/sitemap.xml">Sitemap</a>
            <small class="font-italic d-block">Theme creado por <a class="fw-bold text-primary" href="https://newrisus.com/perfil/Miguel92">Miguel92</a></small>
         </div>
         <div class="d-flex justify-content-center align-items-md-end align-items-center flex-column">
            <span><strong>{$tsConfig.titulo}</strong> © {$smarty.now|date_format:"Y"}.</span>
            <div class="footer__top-link">
               <small>Powered by <a href="https://www.phpost.es" class="text-primary" target="_blank"><strong>PHPost</strong></a> <a class="d-block text-right" href="https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.es" target="_blank" title="CC BY-NC-SA"><img src="https://licensebuttons.net/l/by-nc-sa/3.0/88x31.png" alt="Licencia Creative Common"></a></small>

            </div>
         </div>
      </div>
   </div>
</footer>

{hook 
   name="footer" 
   cdns=["feather-icons"]
   js=['script.js'] 
}
<!-- Contenido en espera -->
{if $tsUser->is_admod && $tsConfig.c_see_mod && $tsConfig.novemods.total}
<div id="stickymsg" class="position-fixed bottom-5 right-2 shadow-3 rounded p-2 bg-danger text-white"  data-url="{$tsConfig.url}/moderacion/">Hay {$tsConfig.novemods.total} contenido{if $tsConfig.novemods.total != 1}s{/if} esperando revisi&oacute;n</div>
{/if}
</body>
</html>