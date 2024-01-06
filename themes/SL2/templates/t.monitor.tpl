{include file='sections/main_header.tpl'}
	<div class="row">
	{if $tsAction == ''}
		<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
	      {include "$tsModulos/m.monitor_content.tpl"}
	   </div>
		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
	      {include "$tsModulos/m.monitor_sidebar.tpl"}
	   </div>
   {else}
		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
		   <ul class="list-unstyled">
            <li class="p-2"><a class="text-{if $tsAction == 'seguidores'}info fw-bold{else}dark{/if}" href="{$tsConfig.url}/monitor/seguidores">Seguidores</a></li>
            <li class="p-2"><a class="text-{if $tsAction == 'siguiendo'}info fw-bold{else}dark{/if}" href="{$tsConfig.url}/monitor/siguiendo">Siguiendo</a></li>
            <li class="p-2"><a class="text-{if $tsAction == 'posts'}info fw-bold{else}dark{/if}" href="{$tsConfig.url}/monitor/posts">Posts</a></li>
         </ul>
		</div>
		<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
	      {include "$tsModulos/m.monitor_listado.tpl"}
	   </div>
   {/if}
   </div>
{include file='sections/main_footer.tpl'}