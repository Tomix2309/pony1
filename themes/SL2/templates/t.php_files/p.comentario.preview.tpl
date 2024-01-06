1:
{if $tsType == 'new'} 
<div id="div_cmnt_{$tsComment.0}">
   <span id="citar_comm_{$tsComment.0}" style="display:none">{$tsComment.2}</span>
   <div class="comentario-post position-relative">
      <div class="avatar-box" style="z-index: 99;">
         <a href="{$tsConfig.url}/perfil/{$tsUser->info.user_name}">
            <img title="{$tsUser->info.user_name}" src="{$tsConfig.url}/files/avatar/{$tsUser->uid}.webp" class="avatar avatar-lg avatar-rounded">
         </a>
      </div>
      <div class="comentario-avatar-content">
          <div class="comment-info clearbeta">
             <div class="position-relative">
                <a href="{$tsConfig.url}/perfil/{$tsUser->nick}" class="text-capitalize text-dark">{$tsUser->nick}</a>  {if $tsUser->is_admod}<span class="text-danger">(IP: <a href="{$tsConfig.url}/moderacion/buscador/1/1/{$tsComment.6}" class="text-danger fw-bold" target="_blank">{$tsComment.6}</a>)</span>{/if} dijo :
                <span class="d-block small text-secondary">{$tsComment.3|hace}</span>
             </div>
             <div class="position-absolute answerOptions">
                <ul>
                {if $tsComment.0 > 0}
                  	{if $tsUser->is_member}
                      <li class="answerCitar">
                      	<a onclick="comentario.citar({$tsComment.0}, '{$tsUser->nick}')"><i data-feather="message-square"></i></a>
                      </li>
                   {/if}
					   {if $tsUser->is_admod || $tsUser->permisos.goepc}
                  	   <li>
                      	<a onclick="comentario.editar({$tsComment.0}, 'show')" title="Editar"><i data-feather="edit-3"></i></a>
                      </li>
					   {/if}
					   {if $tsUser->is_admod || $tsUser->permisos.godpc}
                      <li class="iconDelete">
                          <a onclick="borrar_com({$tsComment.0}, {$tsUser->uid})"><i data-feather="trash"></i></a>
                      </li>
					   {/if}
					   {if $tsUser->is_admod || $tsUser->permisos.moaydcp}
					      <li class="iconHide">
                         <a onclick="ocultar_com({$tsComment.0}, {$tsUser->uid});" title="Ocultar/Mostrar"><i data-feather="eye-off"></i></a>
                      </li>
					   {/if}
                {else}
                   <li><span class="fw-bold text-danger">vista previa</span></li>
                {/if}
                </ul>
             </div>
         </div>
         <div id="comment-body-{$tsComment.0}" class="comment-content" style="text-align:left;">
            {$tsComment.1|nl2br}
         </div>
      </div>
   </div>
</div>

   <script>
   feather.replace({ class: 'featherIcons', 'stroke-width': 1})
   </script>
{elseif $tsType == 'edit'}
<div id="preview" class="box_cuerpo">
    <div id="new-com-html">{$tsComment.1|nl2br}</div>
    <div id="new-com-bbcode" style="display:none">{$tsComment.5}</div>
</div>
{/if}