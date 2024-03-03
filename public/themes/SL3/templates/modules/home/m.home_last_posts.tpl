{if $tsPostsStickys}
   <div class="col-12">
      <h2>Temas fijados</h2>
   </div>
   {foreach from=$tsPostsStickys item=p}
   <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
      {include "m.home_posts.tpl"}
   </div>
   {/foreach}
{/if}
{if $tsPosts}
   <div class="col-12">
      <h2>Otros </h2>
   </div>
   {foreach from=$tsPosts item=p}
   <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
      {include "m.home_posts.tpl"}
   </div>
   {/foreach}
   <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
         {if $tsPages.prev > 0 && $tsPages.max == false}
            <a href="pagina{$tsPages.prev}" class="btn btn-success">&laquo; Anterior</a>
         {/if}
         {if $tsPages.next <= $tsPages.pages}
            <a href="pagina{$tsPages.next}" class="btn btn-success">Siguiente &raquo;</a>
         {elseif $tsPages.max == true}
            <a class="btn btn-success floatL" href="pagina2">Siguiente &raquo;</a>
         {/if}
      </div>
   </div>
{else}
   <div class="col-12">
      <div class="alert alert-warning text-center">No hay posts aqu&iacute;</div>
   </div>
{/if}


{*                        <ul>
                            {if $tsPosts}
                            {foreach from=$tsPosts item=p}
                            
                            {/foreach}
                            {else}
                            <li class="emptyData">No hay posts aqu&iacute;</li>
                            {/if}
                        </ul>
                        <br clear="left"/>
                    
*}