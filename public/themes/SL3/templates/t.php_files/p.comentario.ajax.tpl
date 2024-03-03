{if $tsComments.num > 0}
   {foreach from=$tsComments.data item=c}
   	<!-- COMENZAMOS CON LA IDENTIFICACIÓN DEL COMENTARIO -->
   	<div id="div_cmnt_{$c.cid}">
   		<!-- SI UN USUARIO CITA ESTE COMENTARIO -->
   		<span id="citar_comm_{$c.cid}" style="display:none">{$c.c_body}</span>
   		<!-- ... -->
   		<div class="comentario-post position-relative">
   			<!-- INICIO DEL COMENTARIO -->
   			<div class="comentario-avatar-content">
               <a href="{$tsConfig.url}/perfil/{$c.user_name}">
						<img title="{$c.user_name}" src="{$tsConfig.url}/files/avatar/{$c.c_user}.webp" class="avatar avatar-lg avatar-rounded">
					</a>
               {if $tsUser->is_member && $tsUser->info.user_id != $c.c_user}
                  <ul style="display: none;">
                     <li class="enviar-mensaje"><a href="#" onclick="mensaje.nuevo('{$c.user_name}','','',''); return false">Enviar Mensaje <span></span></a></li>
                     <li class="bloquear {if $tsComments.block}des{/if}bloquear_1"><a href="javascript:bloquear({$c.c_user}, {if $tsComments.block}false{else}true{/if}, 'comentarios')">{if $tsComments.block}Desbloquear{else}Bloquear{/if}</a></li>
						</ul>
               {/if}
            </div>
            <div class="comment-box" id="pp_{$c.cid}" {if $c.c_status == 1 || !$c.user_activo && $tsUser->is_admod}style="opacity:0.5"{/if} >
            	<div class="position-relative">
                  <a href="{$tsConfig.url}/perfil/{$c.user_name}" class="text-capitalize text-dark">@{$c.user_name}</a> {if $tsUser->is_admod}<span class="text-danger">(IP: <a href="{$tsConfig.url}/moderacion/buscador/1/1/{$c.c_ip}" class="text-danger fw-bold" target="_blank">{$c.c_ip}</a>)</span>{/if} dijo : <span class="d-block small text-secondary">{$c.c_date|hace}</span>
                  {if $tsUser->is_member}
                  <div class="position-absolute answerOptions" id="opt_{$c.cid}">
                     <ul id="ul_cmt_{$c.cid}">
								<li class="numbersvotes" {if $c.c_votos == 0}style="display: none"{/if}>
                           <span class="text-{if $c.c_votos >= 0}success{else}danger{/if}" id="votos_total_{$c.cid}">{if $c.c_votos != 0}{if $c.c_votos >= 0}+{/if}{$c.c_votos}{/if}</span>
                        </li>
                        {if $tsUser->uid != $c.c_user && $c.votado == 0 && ($tsUser->permisos.govpp || $tsUser->permisos.govpn || $tsUser->is_admod)}
                           {if $tsUser->permisos.govpp || $tsUser->is_admod}
                              <li class="icon-thumb-up">
                                 <a onclick="comentario.votar({$c.cid},1)"><i data-feather="thumbs-up"></i></a>
                              </li>
                           {/if}
                           {if $tsUser->permisos.govpn || $tsUser->is_admod}
                              <li class="icon-thumb-down">
                                 <a onclick="comentario.votar({$c.cid},-1)"><i data-feather="thumbs-down"></i></a>
                             	</li>
                           {/if}
                        {/if}
                        {if $tsUser->is_member}
                           <li class="answerCitar">
                              <a onclick="comentario.citar({$c.cid}, '{$c.user_name}')" title="Citar"><i data-feather="message-square"></i></a>
                           </li>
	                        {if ($c.c_user == $tsUser->uid && $tsUser->permisos.goepc) || $tsUser->is_admod || $tsUser->permisos.moedcopo}
	                           <li>
	                              <a onclick="comentario.editar({$c.cid}, 'show')" title="Editar comentario"><i data-feather="edit-3"></i></a>
	                           </li>
	                        {/if}
	                        {if ($c.c_user == $tsUser->uid && $tsUser->permisos.godpc) || $tsUser->is_admod || $tsUser->permisos.moecp}
	                           <li class="iconDelete">
	                              <a onclick="borrar_com({$c.cid}, {$c.c_user}, {$c.c_post_id})" title="Borrar"><i data-feather="trash"></i></a>
	                           </li>
										{if $tsUser->is_admod || $tsUser->permisos.moaydcp}
											<li class="iconHide">
		                              <a onclick="ocultar_com({$c.cid}, {$c.c_user});" title="{if $c.c_status == 1}Mostrar/Ocultar{else}Ocultar/Mostrar{/if}"><i data-feather="eye{if $c.c_status != 1}-off{/if}"></i></a>
		                           </li>
										{/if}
	                     	{/if}
	                     {/if}
                     </ul>
                  </div>
                  {/if}
               </div>
               <div id="comment-body-{$c.cid}" class="comment-content">
                  {if $c.c_votos <= -3 || $c.c_status == 1 || !$c.user_activo || $c.user_baneado}<div>Escondido {if $c.c_status == 1}por un moderador{elseif $c.c_votos <= -3}por un puntaje bajo{elseif $c.user_activo == 0}por pertener a una cuenta desactivada{else}por pertenecer a una cuenta baneada{/if}. <a href="#" onclick="$('#hdn_{$c.cid}').slideDown(); $(this).parent().slideUp(); return false;">Click para verlo</a>.</div>
                     <div id="hdn_{$c.cid}" style="display:none">{/if}
                     {$c.c_html}
                     {if $c.c_votos <= -3 || $c.c_status == 1 || !$c.user_activo}</div>{/if}
					</div>
            </div>
   			<!-- FIN DEL COMENTARIO -->
   		</div>
   	</div>
   <script>
	feather.replace({ class: 'featherIcons', 'stroke-width': 1})
	</script>
	{/foreach}
{else}
   <div id="no-comments" class="alert alert-info text-center fw-bolder">Este post no tiene comentarios, S&eacute; el primero!</div>
{/if}
<div id="nuevos"></div>
