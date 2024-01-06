<div class="subMenu py-2">
   <ul class="container sub-nav d-flex justify-content-start align-items-center position-relative">
      {if $tsPage == '' || $tsPage == 'home' || $tsPage == 'posts'}
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
      {elseif $tsPage == 'fotos'}
         <li class="sub-menu{if $tsAction == '' && $tsAction != 'agregar' && $tsAction != 'album' && $tsAction != 'favoritas' || $tsAction == 'ver'} active{/if}"><a href="{$tsConfig.url}/fotos/">Inicio</a></li>
         {if $tsAction == 'album' && $tsFUser.0 != $tsUser->uid}
            <li class="sub-menuactive"><a href="{$tsConfig.url}/fotos/{$tsFUser.1}">&Aacute;lbum de {$tsFUser.1}</a></li>
         {/if}
         {if $tsUser->is_admod || $tsUser->permisos.gopf}
            <li class="sub-menu{if $tsAction == 'agregar'} active{/if}"><a href="{$tsConfig.url}/fotos/agregar.php">Agregar Foto</a></li>
         {/if}
          <li class="sub-menu{if $tsAction == 'album' && $tsFUser.0 == $tsUser->uid} active{/if}"><a href="{$tsConfig.url}/fotos/{$tsUser->nick}">Mis Fotos</a></li>
      {elseif $tsPage == 'tops'}
         <li class="sub-menu{if $tsAction == 'posts'} active{/if}"><a href="{$tsConfig.url}/top/posts/">Posts</a></li>
         <li class="sub-menu{if $tsAction == 'usuarios'} active{/if}"><a href="{$tsConfig.url}/top/usuarios/">Usuarios</a></li>
      {elseif $tsPage == 'files'}
         <li class="sub-menu{if $tsAction == '' && $tsAction != 'favoritos' && $tsAction != 'faqs'} active{/if}"><a href="{$tsConfig.url}/files/">Inicio</a></li>
         {if $tsUser->is_member}
            <li class="sub-menu"><a {if $folderUser.nombre}href="{$tsConfig.url}/files/{$filesUser.user_name}"{else}href="#" onclick="new_folder(); return false;"{/if}>{if $folderUser.nombre}Mis archivos{else}Crear carpeta{/if}</a></li>
            {if $filesUser.total_favs > 0}
            <li class="sub-menu{if $tsAction == 'favoritos'} active{/if}"><a href="{$tsConfig.url}/files/favoritos/">Favoritos</a></li>
            {/if}
         {/if}
         <li class="sub-menu{if $tsAction == 'faqs'} active{/if}"><a href="{$tsConfig.url}/files/faqs/">FAQs</a></li>
      {/if}
   </ul>
</div>