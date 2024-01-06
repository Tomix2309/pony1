<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
   <h2 class="text-uppercase text-center d-block p-2 bg-light">Top post con m&aacute;s...</h2>
   <div class="row">
    	<div class="boxy mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        	<div class="boxy-title">
            <h3>...Puntos</h3>
         </div>
         <div class="boxy-content">
         	{if !$tsTops.puntos}
               <div class="alert alert-warning text-center">Nada por aqui</div>
            {else}
         	<ol class="m-0 p-0 list-unstyled">
             	{foreach from=$tsTops.puntos item=p}
               {if $p.post_puntos > 0}
             	<li class="mb-2">
                  <div class="d-flex justify-content-start align-items-start flex-column">
                     <a class="text-dark" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">{$p.post_title|truncate:45}</a> 
                     <span class="d-block small"><strong onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'">{$p.c_nombre}</strong> - Tiene {$p.post_puntos} Puntos</span>
                  </div>
               </li>
               {/if}
               {/foreach}
            </ol>
            {/if}
         </div>
      </div>
      <!--SEGUIDORES-->
    	<div class="boxy mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        	<div class="boxy-title">
                <h3>...Favoritos</h3>
            </div>
            <div class="boxy-content">
            	{if !$tsTops.favoritos}<div class="alert alert-warning text-center">Nada por aqui</div>
                {else}
            	<ol class="m-0 p-0 list-unstyled">
               {foreach from=$tsTops.favoritos item=p}
               {if $p.post_favoritos > 0}
               <li class="mb-2">
                  <div class="d-flex justify-content-start align-items-start flex-column">
                     <a class="text-dark" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">{$p.post_title|truncate:45}</a> 
                     <span class="d-block small"><strong onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'">{$p.c_nombre}</strong> - Tiene {$p.post_favoritos} Favorito{if $p.post_favoritos > 1}s{/if}</span>
                  </div>
               </li>
               {/if}
               {/foreach}
            </ol>
                {/if}
            </div>
        </div>
        <!--COMENTARIOS-->
    	<div class="boxy mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        	<div class="boxy-title">
                <h3>...Comentado</h3>
            </div>
            <div class="boxy-content">
            	{if !$tsTops.comments}<div class="alert alert-warning text-center">Nada por aqui</div>
                {else}
            	<ol class="m-0 p-0 list-unstyled">
               {foreach from=$tsTops.comments item=p}
               {if $p.post_comments > 0}
               <li class="mb-2">
                  <div class="d-flex justify-content-start align-items-start flex-column">
                     <a class="text-dark" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">{$p.post_title|truncate:45}</a> 
                     <span class="d-block small"><strong onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'">{$p.c_nombre}</strong> - Tiene {$p.post_comments} Comentario{if $p.post_comments > 1}s{/if}</span>
                  </div>
               </li>
               {/if}
               {/foreach}
            </ol>
                {/if}
            </div>
        </div>
        
        <!--SEGUIDORES-->
    	<div class="boxy mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        	<div class="boxy-title">
                <h3>...Seguidores</h3>
            </div>
            <div class="boxy-content">
            	{if !$tsTops.seguidores}<div class="alert alert-warning text-center">Nada por aqui</div>
                {else}
            	<ol class="m-0 p-0 list-unstyled">
               {foreach from=$tsTops.seguidores item=p}
               {if $p.post_seguidores > 0}
               <li class="mb-2">
                  <div class="d-flex justify-content-start align-items-start flex-column">
                     <a class="text-dark" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">{$p.post_title|truncate:45}</a> 
                     <span class="d-block small"><strong onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'">{$p.c_nombre}</strong> - Tiene {$p.post_seguidores} Seguidor{if $p.post_seguidores > 1}es{/if}</span>
                  </div>
               </li>
               {/if}
               {/foreach}
            </ol>
                {/if}
            </div>
        </div>
    </div>
</div>