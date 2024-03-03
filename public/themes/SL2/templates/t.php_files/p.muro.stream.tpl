1:
{if $tsMuro.total}<div id="total_pubs" val="{$tsMuro.total}"></div>{/if}
{include "modules/perfil/m.perfil_muro_story.tpl"}
<script>
   var myLazyLoad = new LazyLoad({
      elements_selector: '.image',
      use_native: true,
      class_loading: 'lazy-loading'
   })
   myLazyLoad.update();
</script>