<div class="box-lateral">
   <div class="box-header">Comentarios<span class="fw-bolder" id="com_total">{$tsCom.total}</span></div>
   <div class="box-body" style="padding: 0">
      {if $tsCom.total > 0}
        {foreach from=$tsCom.com item=c}
         <div class="d-flex justify-content-start align-items-start mb-2" id="comfile_{$c.com_id}">
            <a href="{$tsConfig.url}/perfil/{$c.user_name}" class="me-2" title="{$c.user_name}">
               <img src="{$tsConfig.url}/files/avatar/{$c.com_user}.webp" class="avatar avatar-lg shadow rounded" alt="{$c.user_name}" />
            </a>
            <div class="position-relative w-100">
               <a href="{$tsConfig.url}/perfil/{$c.user_name}" class="text-capitalize fw-bolder text-dark" title="Ver perfil de {$c.user_name}">{$c.user_name}</a></strong> <span class="small">{$c.com_fecha|hace}{if $tsUser->is_admod} ({$c.com_ip}){/if}</span>
               <div class="lead">{$c.com_body|nl2br}</div>
               <div id="c_source_{$c.com_id}" style="display: none;">{$c.com_body_source}</div>
               {if $c.com_user != $tsUser->uid}
                  <a class="position-absolute top-1 right-5" onclick="citar_com({$c.com_id}, '{$c.user_name}')" title="Mencionar a {$c.user_name}"><i data-feather="at-sign"></i></a>
               {/if}
               {if $c.com_user == $tsUser->uid || $tsUser->is_admod}
                  <a class="position-absolute top-1 right-1" onclick="borrar_comfile({$c.com_id}, {$tsFile.data.file_id}, false)" title="Borrar comentario"><i data-feather="trash"></i></a>
               {/if}
            </div> 
        </div>
        {/foreach}
      {else}
         <div id="sincom_file" class="alert alert-warning text-center">No hay comentarios de este archivo.</div>
      {/if}
      <div id="add_new_com"></div>
    </div>
</div>
<div id="alertcom_file"></div>

<!-- AGREGAR NUEVO COMENTARIO -->
{if $tsUser->is_member}
<div class="box-lateral p-2 bg-light" id="add_newcom">
   <div class="box-header position-relative">A&ntilde;adir nuevo comentario <div class="loading loading-sm success" id="newcom_loader" style="display:none;"></div></div>
   <div class="box-body mt-w">
      <textarea id="file_newcom" class="form-input" placeholder="Escribe un nuevo comentario para este archivo..."></textarea>
      <input type="button" onclick="file_newcom({$tsFile.data.file_id})" class="btn btn-success" value="Enviar" id="btn_newcom"/>    
    </div>
</div>
{else}
<div class="emptyData">Para poder comentar tienes que iniciar sesi&oacute;n</div>
{/if}