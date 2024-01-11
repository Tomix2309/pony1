<ol id="filterByTodos" class="filterBy cleanlist" style="display:block;">
  	{foreach from=$tsComments key=i item=c}
	<li class="d-flex justify-content-start align-items-center mb-2">
		<img src="{$tsConfig.url}/files/avatar/{$c.user_id}.webp" alt="{$c.user_name}" class="avatar avatar-rounded me-2">
		<span class="d-block">
			{if $c.post_status != 0 || $c.user_activo == 0 || $c.user_baneado || $c.c_status != 0}
				<a href="{$tsConfig.url}/perfil/{$c.user_name}/" class="d-block text-dark">
					<strong class="text-capitalize" style="color: {if $c.post_status == 3} #BBB {elseif $c.post_status == 1} purple {elseif $c.post_status == 2} rosyBrown {elseif $c.c_status == 1} coral{elseif $c.user_activo == 0} brown {elseif $c.user_baneado == 1} orange {/if};" title="{if $c.post_status == 3} El post se encuentra en revisi&oacute;n{elseif $c.post_status == 1} El post se encuentra oculto por acumulaci&oacute;n de denuncias {elseif $c.post_status == 2} El post se encuentra eliminado {elseif $c.c_status == 1} El comentario est&aacute; oculto{elseif $c.user_activo == 0}El autor del comentario tiene la cuenta desactivada{elseif $c.user_baneado == 1}El autor del comentario tiene la cuenta suspendida{/if}">{$c.user_name}</strong>
				</a>
			{else}
				<a href="{$tsConfig.url}/perfil/{$c.user_name}/" class="d-block text-dark">
					<strong class="text-capitalize">{$c.user_name}</strong>
				</a> 
			{/if}
	      <a href="{$tsConfig.url}/posts/{$c.c_seo}/{$c.post_id}/{$c.post_title|seo}.html#comentarios-abajo" class="small text-secondary">{$c.post_title|truncate:45}</a> 
      </span>
   </li>
   {/foreach}
</ol>
