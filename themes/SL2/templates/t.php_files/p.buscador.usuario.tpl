{if $tsListaU}
	{foreach $tsListaU item=user}
	<div class="d-inline-block">
		<div class="userFound d-flex justify-content-start align-items-center">
			<img src="{$tsConfig.url}/files/avatar/{$user.user_id}.webp" class="avatar avatar-circle shadow">
			<span>
				<a class="d-block fw-bolder text-dark" href="{$tsConfig.url}/perfil/{$user.user_name}" style="margin-bottom: -6px;">{$user.user_name} #{$user.user_id}</a>
				<small class="text-{if $user.user_activo == 1 && $user.user_baneado == 0}success{else}danger{/if} fw-bold">{if $user.user_baneado == 1}Baneado{else}{if $user.user_activo == 1}Activado{else}Cuenta desactivada{/if}{/if}</small>
			</span>
		</div>
	</div>
	{/foreach}
{else}
	<div class="alert alert-warning">No se encontro al usuario que buscas</div>
{/if}