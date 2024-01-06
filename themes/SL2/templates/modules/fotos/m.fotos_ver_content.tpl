{if $tsFoto.f_status != 0 || $tsFoto.user_activo == 0}
   <div class="alert alert-warning">Esta foto no es visible{if $tsFoto.f_status == 1} por acumulaci&oacute;n de denuncias u orden administrativa{elseif $tsFoto.f_status == 2} porque est&aacute; eliminada{elseif $tsFoto.user_activo != 1} porque la cuenta del due&ntilde;o se encuentra desactivada{/if}, pero puedes verla porque eres {if $tsUser->is_admod == 1}administrador{elseif $tsUser->is_admod == 2}moderador{else}autorizado{/if}.</div><br />
{/if}
<div class="bg-light p-2 photo_author">
   <img src="{$tsConfig.url}/files/avatar/{$tsFoto.f_user}.webp" class="rounded shadow" alt="{$tsFoto.user_name}" />
   <div class="d-flex justify-content-center align-items-start flex-column">
      <a href="{$tsConfig.url}/perfil/{$tsFoto.user_name}" class="h5 text-dark text-capitalize fw-bolder">{$tsFoto.user_name}</a>
      <span class="d-block" style="margin-top:-6px">
         <span class="d-block small" style="color:#{$tsFoto.r_color}">{$tsFoto.r_name}</span>
         <i class="flag-icon flag-icon-{$tsFoto.user_pais.0|lower}"></i>
         {if $tsUser->uid != $tsFoto.f_user && $tsUser->is_member}
            <a class="btn btn-danger btn-sm unfollow_user_post" onclick="notifica.unfollow('user', {$tsFoto.f_user}, notifica.userInPostHandle, $(this).children('span'))" {if $tsFoto.follow == 0}style="display: none;"{/if}>Dejar de seguir</a>
            <a class="btn btn-info btn-sm follow_user_post" onclick="notifica.follow('user', {$tsFoto.f_user}, notifica.userInPostHandle, $(this).children('span'))" {if $tsFoto.follow == 1}style="display: none;"{/if}> Seguir Usurio</a>
            {if $tsUser->is_member && $tsUser->uid != $tsFoto.f_user}
               <a class="btn btn-success btn-sm" href="#" onclick="mensaje.nuevo('{$tsFoto.user_name}','','',''); return false;">Enviar Mensaje</a>
            {/if}
         {/if}
      </span>
   </div>
</div>
<div class="p-2 text-center position-relative photo">
   {if $tsFoto.f_user == $tsUser->uid || $tsUser->is_admod || $tsUser->permisos.moef || $tsUser->permisos.moedfo}
   <div class="photo_tools">
      {if $tsFoto.f_status != 2 && ($tsUser->is_admod || $tsUser->permisos.moef || $tsFoto.f_user == $tsUser->uid)}
         <a href="#" class="mr-1 btn btn-sm btn-danger"onclick="{if $tsUser->uid == $tsFoto.f_user}fotos.borrar({$tsFoto.foto_id}, 'foto'); {else}mod.fotos.borrar({$tsFoto.foto_id}, 'foto'); {/if} return false;">Borrar</a>
      {/if}
      {if $tsUser->is_admod || $tsUser->permisos.moedfo || $tsFoto.f_user == $tsUser->uid}
         <a href="#" class="mr-1 btn btn-sm btn-success"onclick="location.href='{$tsConfig.url}/fotos/editar.php?id={$tsFoto.foto_id}'; return false">Editar</a>
      {/if}
   </div>
   {/if}
   <img class="img" src="{$tsFoto.f_url}" alt="{$tsFoto.f_title}" class="rounded w-100" />
</div>
<div class="d-flex justify-content-between align-items-center photo_title">
   <div>
      <h5>{$tsFoto.f_title}</h5>
      <small>{$tsFoto.f_hits} Visualizaciones &bull; {$tsFoto.f_date|date_format:"%d %b %Y"}{if $tsUser->is_admod} &bull; <a href="{$tsConfig.url}/moderacion/buscador/1/1/{$tsFoto.f_ip}" class="text-dark" target="_blank">{$tsFoto.f_ip}</a>{/if}</small>
   </div>
   <div class="photo_options position-relative">
      <div class="vp d-flex justify-content-center align-items-center text-success"><i data-feather="thumbs-up" onclick="fotos.votar('pos'); return false;"></i> <span id="votos_total_pos">{$tsFoto.f_votos_pos}</span></div>
      <div class="vn d-flex justify-content-center align-items-center text-danger"><i data-feather="thumbs-down" onclick="fotos.votar('neg'); return false;"></i> <span id="votos_total_neg">{$tsFoto.f_votos_neg}</span></div>
   </div>
</div>
<div class="fotos-descrp" style="word-wrap: break-word;">{$tsFoto.f_description|nl2br}</div>
<div class="bg-light mt-3 p-2">
   <h4 class="m-0 p-0"><span id="ncomments">{$tsFoto.f_comments}</span> Comentarios</h4>
</div>
{if $tsUser->is_admod == 0 && $tsUser->permisos.gopcf == false}
   <div id="no-comments" class="alert alert-danger">No tienes permiso para comentar.</div>
{elseif $tsFoto.f_closed == 1}
   <div id="no-comments" class="alert alert-warning">La foto se encuentra cerrada y no se permiten comentarios.</div>
{elseif $tsUser->is_member}
   <div class="form p-3">
      <img alt="{$c.user_name}" class="rounded shadow" src="{$tsConfig.url}/files/avatar/{$tsUser->uid}.webp">
      <form method="post" action="" name="firmar">
         <div class="error"></div>
         <textarea name="mensaje" id="mensaje" rows="2" class="onblur_effect form-input" title="Escribe un mensaje." onblur="onblur_input(this)" onfocus="onfocus_input(this)">Escribe un mensaje.</textarea>
         <input type="hidden" name="auser_post" value="{$tsFoto.f_user}" />
         <input type="button" id="btnComment" class="btn btn-success" value="Comentar" onclick="fotos.comentar()" />
      </form>
   </div>
{else}
   <div class="alert alert-info">Para poder comentar necesitas estar <a class="text-white" onclick="registro_load_form(); return false" href="">Registrado.</a> O.. ya tienes usuario? <a class="text-white" onclick="open_login_box('open')" href="#">Logueate!</a></div>
{/if}
<div class="comments">
   <div id="mensajes">
   {if $tsFComments}
      {foreach from=$tsFComments item=c}
         <div class="item" id="div_cmnt_{$c.cid}">
            <a href="{$tsConfig.url}/perfil/{$c.user_name}">
               <img src="{$tsConfig.url}/files/avatar/{$c.c_user}.webp" class="rounded shadow"/>
            </a>
            <div class="firma">
               <div class="options position-relative">
                  {if $tsFoto.f_user == $tsUser->info.user_id || $tsUser->is_admod || $tsUser->permisos.moecf}
                     <a href="#" class="position-absolute" style="right:3px;top:3px" onclick="fotos.borrar({$c.cid}, 'com'); return false"><i data-feather="x"></i></a>
                  {/if}
                  <div class="comment-box" id="pp_{$c.cid}">
                     <div class="comment-info">
                        <a href="{$tsConfig.url}/fotos/{$c.user_name}" class="text-dark">@{$c.user_name}</a> <span> {$c.c_date|hace} {if $tsUser->is_admod}(<span>IP:</span> <a href="{$tsConfig.url}/moderacion/buscador/1/1/{$c.c_ip}" class="text-dark" target="_blank">{$c.c_ip}</a>){/if} dijo:</span>
                     </div>
                     {if !$c.user_activo}<div>Escondido por pertener a una cuenta desactivada
                        <a href="#" onclick="$('#hdn_{$c.cid}').slideDown(); $(this).parent().slideUp(); return false;">Click para verlo</a>.</div>
                     <div id="hdn_{$c.cid}" style="display:none">{/if} 
                     <div class="comment-content">{$c.c_body|nl2br}</div>
                     {if !$c.user_activo}</div>{/if}
                  </div>
               </div>
            </div>
         </div>
      {/foreach}
   {elseif $tsFoto.f_closed == 0 && ($tsUser->is_admod || $tsUser->permisos.gopcf)}
      <div id="no-comments" class="alert alert-info">Esta foto no tiene comentarios, Se el primero!.</div>
   {/if}
   </div>
</div>