{if $tsMoreSeeComment}
   <ul class="list-unstyled">
      {foreach from=$tsMoreSeeComment item=p}
         <li>
            {image type="portada" alt="{$tsPost.post_title}" src="{$p.post_portada}" class="rounded shadow"}
				<a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">
               {$p.post_title|truncate:32}
            </a>
			</li>
      {/foreach}
   </ul>
{else}
   <div class="alert alert-warning text-center">No se encontraron posts relacionados.</div>
{/if}