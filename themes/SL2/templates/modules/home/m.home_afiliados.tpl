<div class="box-lateral">
   <div class="box-header">Afiliados <a onclick="afiliado.nuevo(); return false"><i data-feather="plus"></i></a></div>
   <div class="box-body">
      {foreach from=$tsAfiliados item=af}
         <a href="#" onclick="afiliado.detalles({$af.aid}); return false;" title="{$af.a_titulo}" class="d-block m-2 bg-light">
            <img src="{$af.a_banner}" class="rounded w-100 object-fit-cover" alt="{$af.a_titulo}" height="68"/>
         </a>
      {/foreach}
      <a class="btn btn-sm btn-block btn-primary" href="javascript:afiliado.nuevo()">Afiliate a {$tsConfig.titulo}</a>
   </div>
</div>
