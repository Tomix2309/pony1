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
         <div class="phpost">
            <h3 class="h5 m-0 p-2 bg-light">{$tsConfig.titulo} en directo</h3>
            <ul id="ulitmas_noticias" class="pp_list">
               <div class="hero hero-info text-center hero-lg">
                  <div class="hero-body">
                     <h3>Cargando...</h3>
                  </div>
               </div>
            </ul>
         </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
         <div class="phpost version">
            <h3 class="h5 m-0 mt-2 p-2 bg-light">{$tsConfig.titulo}</h3>
            <ul id="ultima_version" class="pp_list">
               <li class="list-clone ml-2 mb-3">
                  <div class="title fw-bold">Versi&oacute;n instalada</div>
                  <div class="body text-secondary small">{$tsConfig.version}</div>
               </li>
            </ul>
            <h3 class="h5 m-0 mt-2 p-2 bg-light">Administradores</h3>
            <ul class="pp_list">                                    
               {foreach from=$tsAdmins item=admin}
                  <li><div class="title"><a href="{$tsConfig.url}/perfil/{$admin.user_name}" data-vcard="{$admin.user_id}">{$admin.user_name}</a></div></li>                                    
               {/foreach}
            </ul>
            <h3 class="h5 m-0 mt-2 p-2 bg-light">Instalaciones</h3>
            <ul class="pp_list">
			      <li class="px-1 py-2">Fundaci&oacute;n<span class="float-end small badge badge-info" title="{$tsInst.0|fecha}">{$tsInst.0|hace:true}</span></li>
			      <li class="px-1 py-2">Actualizado<span class="float-end small badge badge-info" title="{$tsInst.1|fecha}">{$tsInst.1|hace:true}</span></li>
	        </ul>
         </div>
      </div>
   </div>
</div>
<script src="{$tsConfig.js}/versiones.js?{$smarty.now}"></script>