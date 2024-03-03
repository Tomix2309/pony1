<div class="post-contenedor p-2 position-relative">
	{if $tsPost.post_user == $tsUser->uid && $tsUser->is_admod == 0 && $tsUser->permisos.most == false && $tsUser->permisos.moayca == false && $tsUser->permisos.moo == false && $tsUser->permisos.moep ==  false && $tsUser->permisos.moedpo == false}
		<div class="d-flex justify-content-around align-items-center">
			<a title="Borrar Post" href="javascript:borrar_post(); return false;" class="btn btn-danger">Borrar</a>
			<a title="Editar Post" href="{$tsConfig.url}/posts/editar/{$tsPost.post_id}" class="btn btn-success">Editar</a>
      </div>
	{elseif ($tsUser->is_admod && $tsPost.post_status == 0) || $tsUser->permisos.most || $tsUser->permisos.moayca || $tsUser->permisos.moop || $tsUser->permisos.moep || $tsUser->permisos.moedpo}
		<div class="d-flex justify-content-around align-items-center">
			{if $tsUser->is_admod || $tsUser->permisos.most}<a href="#" onclick="mod.reboot({$tsPost.post_id}, 'posts', 'sticky', false); if($(this).text() == 'Poner Sticky') $(this).text('Quitar Sticky'); else $(this).text('Poner Sticky'); return false;" class="btn btn-{if $tsPost.post_sticky == 1}danger{else}success{/if}">{if $tsPost.post_sticky == 1}Quitar{else}Poner{/if} Sticky</a>{/if}
			{if $tsUser->is_admod || $tsUser->permisos.moayca}<a href="#" onclick="mod.reboot({$tsPost.post_id}, 'posts', 'openclosed', false); if($(this).text() == 'Cerrar Post') $(this).text('Abrir Post'); else $(this).text('Cerrar Post'); return false;" class="btn btn-{if $tsPost.post_block_comments == 1}primary{else}warning{/if}">{if $tsPost.post_block_comments == 1}Abrir{else}Cerrar{/if} Post</a>{/if}
			{if $tsUser->is_admod || $tsUser->permisos.moop}<a id="desaprobar" href="#" onclick="$('#desapprove').slideToggle(); $(this).fadeOut().remove();" class="btn btn-warning">Ocultar Post</a>{/if}
			{if $tsUser->is_admod || $tsUser->permisos.moedpo || $tsAutor.user_id == $tsUser->uid}<a href="{$tsConfig.url}/posts/editar/{$tsPost.post_id}" class="btn btn-info">Editar</a>{/if}
			{if $tsUser->is_admod || $tsUser->permisos.moep || $tsAutor.user_id == $tsUser->uid}<a style="border-right: 1px solid #ECECEC;" href="#" onclick="{if $tsAutor.user_id != $tsUser->uid}mod.posts.borrar({$tsPost.post_id}, 'posts', null);{else}borrar_post();{/if} return false;" class="btn btn-danger">Borrar</a>{/if}
      </div>
		<div id="desapprove" style="display:none;">
			<span style="display: none;" class="errormsg"></span>
			<div class="form-group d-flex justify-content-start align-items-center">
				<input type="text" id="d_razon" name="d_razon" maxlength="150" size="60" class="form-input" placeholder="Raz&oacute;n de la revisi&oacute;n" required>
				<input type="button" class="btn btn-danger btnDelete" name="desapprove" value="Continuar" href="#" onclick="mod.posts.ocultar('{$tsPost.post_id}'); return false;"/>
			</div>
		</div>
	{/if}
	{include "$tsModulos/m.posts_comparte.tpl"}
	<br>
	{if !$tsUser->is_member}{include "modules/m.global_ads_728.tpl"}<br>{/if}
	<span class="d-block">{$tsPost.post_body}</span>
	<br>
	{include "modules/m.global_ads_728.tpl"}
	<br>
	{include "$tsModulos/m.posts_comparte.tpl"}
	{if $tsPost.user_firma && $tsConfig.c_allow_firma}
		<span class="p-2 bg-light d-block my-2 text-dark text-center">{$tsPost.user_firma}</span>
	{/if}
	{include "$tsModulos/m.posts_metadata.tpl"}
</div>