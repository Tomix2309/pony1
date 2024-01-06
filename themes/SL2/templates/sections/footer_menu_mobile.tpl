<div class="position-fixed bottom-3 right-3 zIndex99 bg-white" menu="close">
   <span data-change="open" class="d-flex justify-content-center align-items-center w-100 h-100"><i data-feather="menu"></i></span>
   <span data-change="close" class="d-none"><i data-feather="x"></i></span>
   <div class="content-box">
      <h4>{$tsConfig.titulo}</h4>
      <sidenav>
         {if $tsConfig.c_allow_portal && $tsUser->is_member == true}
            <div class="item {if $tsPage == 'mi'} active{/if}">
               <a class="d-flex justify-content-start align-items-center" title="Ir a Inicio" href="{$tsConfig.url}/mi/"><i data-feather="home"></i> Portal</a>
            </div>
         {/if}

         <!-- POSTS -->
         <div class="item{if $tsPage == 'posts' || $tsPage == 'home'} active{/if}">
            <a class=" d-flex justify-content-start align-items-center" title="Ir a Posts" href="javascript:clicMenu('posts')"><i data-feather="file-text"></i> Posts</a>
         </div>  
         <div class="subitem bg-white shadow rounded" data="posts">
            <ul class="list-unstyled">
               <li class="sub-menu{if $tsPage == 'home' || $tsPage == 'portal'} active{/if}"><a title="Inicio" href="{$tsConfig.url}/{if $tsPage == 'home' || $tsPage == 'posts'}posts/{/if}">Inicio</a></li>
               <li class="sub-menu{if $tsPage == 'buscador'} active{/if}"><a title="Buscador" href="{$tsConfig.url}/buscador/">Buscador</a></li>
               {if $tsUser->is_member}
                  {if !$tsMobile}
                     {if $tsUser->is_admod || $tsUser->permisos.gopp}
                        <li class="sub-menu{if $tsSubmenu == 'agregar'} active{/if}"><a title="Agregar Post" href="{$tsConfig.url}/agregar/">Agregar Post</a></li>
                     {/if}
                     <li class="sub-menu{if $tsPage == 'mod-history'} active{/if}"><a title="Historial de Moderaci&oacute;n" href="{$tsConfig.url}/mod-history/">Historial</a></li>
                  {/if}
                  {if $tsUser->is_admod || $tsUser->permisos.moacp}
                     <li class="sub-menu{if $tsPage == 'moderacion'} active{/if}"><a title="Panel de Moderador" href="{$tsConfig.url}/moderacion/">Moderaci&oacute;n {if $tsConfig.c_see_mod && $tsConfig.novemods.total}<span class="cadGe cadGe_{if $tsConfig.novemods.total < 10}green{elseif $tsConfig.novemods.total < 30}purple{else}red{/if}" style="position:relative;">{$tsConfig.novemods.total}</span>{/if}</a></li>
                  {/if}
               {/if}
            </ul>
         </div>
         <!-- END POSTS -->

         {if $tsConfig.c_fotos_private == '1' && !$tsUser->is_member}{else}                      
            <div class="item {if $tsPage == 'fotos'}active{/if}">
               <a class=" d-flex justify-content-start align-items-center" title="Ir a Fotos" href="javascript:clicMenu('fotos')"><i data-feather="camera"></i> Fotos</a>
            </div>
         	<div class="subitem bg-white shadow rounded" data="fotos">
	            <ul class="list-unstyled">
	         		<li class="sub-menu{if $tsAction == '' && $tsAction != 'agregar' && $tsAction != 'album' && $tsAction != 'favoritas' || $tsAction == 'ver'} active{/if}"><a href="{$tsConfig.url}/fotos/">Inicio</a></li>
			         {if $tsAction == 'album' && $tsFUser.0 != $tsUser->uid}
			            <li class="sub-menu active"><a href="{$tsConfig.url}/fotos/{$tsFUser.1}">&Aacute;lbum de {$tsFUser.1}</a></li>
			         {/if}
			         {if $tsUser->is_admod || $tsUser->permisos.gopf}
			            <li class="sub-menu{if $tsAction == 'agregar'} active{/if}"><a href="{$tsConfig.url}/fotos/agregar.php">Agregar Foto</a></li>
			         {/if}
			         <li class="sub-menu{if $tsAction == 'album' && $tsFUser.0 == $tsUser->uid} active{/if}"><a href="{$tsConfig.url}/fotos/{$tsUser->nick}">Mis Fotos</a></li>
			      </ul>
         	</div>                   
         {/if}

         <div class="item{if $tsPage == 'tops'} active{/if}">
            <a class=" d-flex justify-content-start align-items-center" title="Ir a TOPs" href="javascript:clicMenu('tops')"><i data-feather="trending-up"></i> TOPs</a>
         </div>
         <div class="subitem bg-white shadow rounded" data="tops">
            <ul class="list-unstyled">
		         <li class="sub-menu{if $tsAction == 'posts'} active{/if}"><a href="{$tsConfig.url}/top/posts/">Posts</a></li>
		         <li class="sub-menu{if $tsAction == 'usuarios'} active{/if}"><a href="{$tsConfig.url}/top/usuarios/">Usuarios</a></li>
		      </ul>
         </div>

         <div class="item{if $tsPage == 'files'} active{/if}">
            <a class=" d-flex justify-content-start align-items-center" title="Ir a Archivos" href="javascript:clicMenu('files')"><i data-feather="archive"></i> Archivos</a>
         </div>
         <div class="subitem bg-white shadow rounded" data="files">
            <ul class="list-unstyled">
	         	<li class="sub-menu{if $tsAction == '' && $tsAction != 'favoritos' && $tsAction != 'faqs'} active{/if}"><a href="{$tsConfig.url}/files/">Inicio</a></li>
	         	{if $tsUser->is_member}
	            	<li class="sub-menu"><a {if $folderUser.nombre}href="{$tsConfig.url}/files/{$filesUser.user_name}"{else}href="#" onclick="new_folder(); return false;"{/if}>{if $folderUser.nombre}Mis archivos{else}Crear carpeta{/if}</a></li>
	            	{if $filesUser.total_favs > 0}
		            	<li class="sub-menu{if $tsAction == 'favoritos'} active{/if}"><a href="{$tsConfig.url}/files/favoritos/">Favoritos</a></li>
		            {/if}
		         {/if}
		         <li class="sub-menu{if $tsAction == 'faqs'} active{/if}"><a href="{$tsConfig.url}/files/faqs/">FAQs</a></li>
		      </ul>
         </div>

         <!-- SI SE HA INICIADO SESIÓN -->
         {if $tsUser->is_member}
            {if $tsUser->is_admod == 1}
           	<!-- SE ES ADMINISTRADOR -->
               <div class="item{if $tsPage == 'admin'} active{/if}">
                  <a class=" d-flex justify-content-start align-items-center" title="Panel de Administrador" href="{$tsConfig.url}/admin/"><i data-feather="sliders"></i> Administraci&oacute;n</a>
               </div>
            {/if} 
         {else}
            <div class="item">
               <a class=" d-flex justify-content-start align-items-center" alt="Iniciar sesión" href="{$tsConfig.url}/login/"><i data-feather="log-in"></i> Acceder</a>
            </div>
            <div class="item">
               <a class=" d-flex justify-content-start align-items-center" alt="Crear mi cuenta" href="{$tsConfig.url}/registro/"><i data-feather="user-plus"></i> Registrate!</a>
            </div>
         {/if}
      </sidenav>
   </div>
</div>
<script>
function clicMenu(cual) {
	$('.subitem[data='+cual+']').toggleClass('open');
	console.log($('.subitem[data='+cual+']').parent());
}
$(document).ready(function(){
	$('span[data-change="open"]').on('click', function(e){
		const ty = $(this).attr('data-change');
		$(this).parent().attr('menu', ty);
		$(this).removeClass('d-flex').addClass('d-none');
		$('span[data-change="close"]').removeClass('d-none');
	});
	$('span[data-change="close"]').on('click', function(e){
		const ty = $(this).attr('data-change');
		$(this).parent().attr('menu', ty);
		$(this).addClass('d-none');
		$('span[data-change="open"]').removeClass('d-none').addClass('d-flex');
	});

});
</script>