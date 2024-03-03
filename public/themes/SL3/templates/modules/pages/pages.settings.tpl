{if $tsUser->is_admod == 1}

   <div class="hero">
      <div class="hero-body">
         <h1 class="fs-2">Sistema de control de la web</h1>
         <p>En esta página se podrá hacer configuraciones para el aspecto de la web, el nombre e id se guardará en el caché de tu navegador, para así de esta forma poder localizar el archivo de configuración y asi cada usuario tendrá su propio estilo.</p>
         <a href="{$tsConfig.url}/pages/settings/?tab=seo" class="btn btn-{if $tsTab == 'seo'}primary{else}secondary{/if} btn-sm">Configurar SEO</a>
         <a href="{$tsConfig.url}/pages/settings/?tab=header" class="btn btn-{if $tsTab == 'header'}primary{else}secondary{/if} btn-sm">Configurar Header</a>
      </div>
   </div>

   {include "settings/settings.$tsTab.tpl"}

   <script src="{$tsConfig.js}/settings.js?{$smarty.now}"></script>
{else}
   <div class="hero">
      <div class="hero-body">
         <h1>Que haces?</h1>
         <p>Tú no tienes permitido ver esta sección, bueno si la ves, pero no puedes hacer nada a no ser que seas administrador</p>
      </div>
   </div>
{/if}