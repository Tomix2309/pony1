<div class="boxy-title">
   <h3>Centro de Administraci&oacute;n</h3>
</div>
<div id="res" class="boxy-content">
   <div class="hero hero-lg">
      <div class="hero-body"><h4>Bienvenido(a), {$tsUser->nick}!</h4>
      <p>Este es tu &quot;<b>Centro de Administraci&oacute;n de {$tsConfig.titulo}</b>&quot;. Aqu&iacute; puedes modificar la configuraci&oacute;n de tu web, modificar usuarios, modificar posts, y muchas otras cosas.<br />Si tienes algun problema, por favor revisa la p&aacute;gina de &quot;<b>Soporte y Cr&eacute;ditos</b>&quot;.  Si esa informaci&oacute;n no te sirve, puedes <a href="http://www.phpost.es/" class="text-info" target="_blank">visitarnos para solicitar ayuda</a> acerca de tu problema.</p></div>
   </div>
   <hr class="separator" />
   <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
         <!-- INFOMACIÓN DEL ÚLTIMO COMMIT -->
         <div class="panel-info last-commit card mb-3">
            <h5 class="card-header">Último commit en Github</h5>
            <div id="lastCommit" class="card-body">
               <div class="phpostAlfa">Cargando...</div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center"></div>
         </div>

         <div class="phpost">
            <h3 class="h5 mb-2 p-2 bg-dark-subtle">{$tsConfig.titulo} en directo</h3>
            <ul id="ulitmas_noticias" class="pp_list list-unstyled">
               <div class="emptyData">Cargando...</div>
            </ul>
         </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
         <div class="phpost version">
            <h3 class="h5 mb-2 mt-2 p-2 bg-dark-subtle">{$tsConfig.titulo}</h3>
            <ul id="ultima_version" class="pp_list list-unstyled list-group-flush">
               <li class="list-clone ms-2 mb-3 px-2 py-1">
                  <div class="title fw-bold">Versi&oacute;n instalada</div>
                  <div class="body text-secondary small">{$tsConfig.version}</div>
               </li>
            </ul>
            <h3 class="h5 mb-2 mt-2 p-2 bg-dark-subtle">Administradores</h3>
            <ul class="pp_list list-unstyled">                                    
               {foreach from=$tsAdmins item=admin}
                  <li><a class="badge bg-success-subtle text-success-emphasis" rel="internal" href="{$tsConfig.url}/perfil/{$admin.user_name}">{$admin.user_name}</a></li>
               {/foreach}
            </ul>
            <h3 class="h5 mb-2 mt-2 p-2 bg-dark-subtle">Instalaciones</h3>
            <ul class="pp_list list-group list-group-flush">
               <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">Fundaci&oacute;n</div>
                  <span class="badge bg-primary rounded-pill">{$tsInst.0|hace:true}</span>
              </li>
               <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">Actualizado</div>
                  <span class="badge bg-primary rounded-pill">{$tsInst.1|hace:true}</span>
              </li>
	        </ul>
         </div>
      </div>
   </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-toolkit/extras/css/joypixels.min.css">
<script src="https://cdn.jsdelivr.net/combine/npm/timeago,npm/emoji-toolkit"></script>
<script src="{$tsConfig.js}/versiones.js?{$smarty.now}"></script>