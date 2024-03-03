<div class="d-flex justify-content-start align-items-start mb-2" id="comfile_{$newCom.4}">
   <a href="{$tsConfig.url}/perfil/{$newCom.2}" class="me-2" title="{$newCom.2}">
      <img src="{$tsConfig.url}/files/avatar/{$newCom.1}.webp" class="avatar avatar-lg shadow rounded" alt="{$newCom.2}" />
   </a>
   <div class="position-relative w-100">
      <a href="{$tsConfig.url}/perfil/{$newCom.2}" class="text-capitalize fw-bolder text-dark" title="Ver perfil de {$newCom.2}">{$newCom.2}</a></strong>
      <div class="lead">{$newCom.0|nl2br}</div>
      <a class="position-absolute top-1 right-1" onclick="borrar_comfile({$newCom.4}, {$newCom.5}, false)" title="Borrar comentario"><i data-feather="trash"></i></a>
   </div> 
</div>