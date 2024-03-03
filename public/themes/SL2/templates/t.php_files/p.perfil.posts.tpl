1:
<div id="perfil_posts" status="activo">
    <div class="widget w-posts clearfix">
    	<div class="title-w clearfix">
            <h3 style="margin-top: 2px;">&Uacute;ltimos Posts creados por {$tsUsername}</h3>
        </div>
        {if $tsGeneral.posts}
        <ul class="ultimos">
            {foreach from=$tsGeneral.posts item=p}
        	<li class="categoriaPost cat-posts">
                <a title="{$p.post_title}" target="_self" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html">{$p.post_title|truncate:45}</a>
                <span class="fw-bolder">{$p.c_nombre}</span>
                <span>{$p.post_puntos} Puntos</span>
            {/foreach}
            {if $tsGeneral.total >= 18}
            <li class="see-more"><a href="{$tsConfig.url}/buscador/?autor={$tsGeneral.username}">Ver m&aacute;s &raquo;</a></li>
            {/if}
        </ul>
        {else}
        <div class="alert alert-warning text-center">No hay posts</div>
        {/if}
    </div>
</div>