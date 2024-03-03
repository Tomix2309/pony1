{include file='sections/main_header.tpl'}
<div class="row">
	{include "m.top_sidebar.tpl"}
   {if $tsAction == 'posts'}
		{include "m.top_posts.tpl"}
   {elseif $tsAction == 'usuarios'}
      {include "m.top_users.tpl"}
   {/if} 
</div>            
{include file='sections/main_footer.tpl'}