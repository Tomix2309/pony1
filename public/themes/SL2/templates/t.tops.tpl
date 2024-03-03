{include file='sections/main_header.tpl'}
<div class="row">
	{include "$tsModulos/m.top_sidebar.tpl"}
   {if $tsAction == 'posts'}
		{include "$tsModulos/m.top_posts.tpl"}
   {elseif $tsAction == 'usuarios'}
      {include "$tsModulos/m.top_users.tpl"}
   {/if} 
</div>            
{include file='sections/main_footer.tpl'}