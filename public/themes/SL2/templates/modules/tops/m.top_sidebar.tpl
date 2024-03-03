<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
	<div class="box-lateral">
    	<div class="boxy-header"><h4>Filtrar</h4></div>
         <div class="box-body">
            <select class="form-select" onchange="location.href='{$tsConfig.url}/top/{$tsAction}/?fecha={$tsFecha}&cat='+$(this).val()">
            <option value="0">Todas</option>
            {foreach from=$tsConfig.categorias item=c}
               <option value="&cat={$c.cid}" {if $tsCat == $c.cid}selected="selected"{/if}>{$c.c_nombre}</option>
            {/foreach}
            </select>
            <h4 class="bg-light p-1 mt-2">Per&iacute;odo</h4>
            <ul class="list-unstyled">
               <li><a href="{$tsConfig.url}/top/{$tsAction}/?fecha=2&cat={$tsCat}&sub={$tsSub}" class="p-2 d-block text-{if $tsFecha == 2}white shadow rounded bg-info{else}info{/if}">Ayer</a></li>
               <li><a href="{$tsConfig.url}/top/{$tsAction}/?fecha=1&cat={$tsCat}&sub={$tsSub}" class="p-2 d-block text-{if $tsFecha == 1}white shadow rounded bg-info{else}info{/if}">Hoy</a></li>
               <li><a href="{$tsConfig.url}/top/{$tsAction}/?fecha=3&cat={$tsCat}&sub={$tsSub}" class="p-2 d-block text-{if $tsFecha == 3}white shadow rounded bg-info{else}info{/if}">&Uacute;ltimos 7 d&iacute;as</a></li>
               <li><a href="{$tsConfig.url}/top/{$tsAction}/?fecha=4&cat={$tsCat}&sub={$tsSub}" class="p-2 d-block text-{if $tsFecha == 4}white shadow rounded bg-info{else}info{/if}">Del mes</a></li>
               <li><a href="{$tsConfig.url}/top/{$tsAction}/?fecha=5&cat={$tsCat}&sub={$tsSub}" class="p-2 d-block text-{if $tsFecha == 5}white shadow rounded bg-info{else}info{/if}">Todos los tiempos</a></li>
            </ul>
        </div>
    </div>
</div>