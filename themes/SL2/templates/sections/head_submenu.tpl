<div class="subnavegation">
   <div class="container">
      {if $tsPage == '' || $tsPage == 'home' || $tsPage == 'posts'}
         <div class="item{if $tsPage == 'home' || $tsPage == 'portal'} active{/if}"><a title="Inicio" href="{$tsConfig.url}/{if $tsPage == 'home' || $tsPage == 'posts'}posts/{/if}">Inicio</a></div>
         <div class="item{if $tsPage == 'buscador'} active{/if}"><a title="Buscador" href="{$tsConfig.url}/buscador/">Buscador</a></div>
         {if $tsUser->is_member}
            {if !$tsMobile}
               {if $tsUser->is_admod || $tsUser->permisos.gopp}
                  <div class="item{if $tsSubmenu == 'agregar'} active{/if}"><a title="Agregar Post" href="{$tsConfig.url}/agregar/">Agregar Post</a></div>
               {/if}
               <div class="item{if $tsPage == 'mod-history'} active{/if}"><a title="Historial de Moderaci&oacute;n" href="{$tsConfig.url}/mod-history/">Historial</a></div>
            {/if}
        	   {if $tsUser->is_admod || $tsUser->permisos.moacp}
               <div class="item{if $tsPage == 'moderacion'} active{/if}"><a title="Panel de Moderador" href="{$tsConfig.url}/moderacion/">Moderaci&oacute;n {if $tsConfig.c_see_mod && $tsConfig.novemods.total}<span class="cadGe cadGe_{if $tsConfig.novemods.total < 10}green{elseif $tsConfig.novemods.total < 30}purple{else}red{/if}" style="position:relative;">{$tsConfig.novemods.total}</span>{/if}</a></div>
            {/if}
         {/if}
      {elseif $tsPage == 'fotos'}
         <div class="item{if $tsAction == '' && $tsAction != 'agregar' && $tsAction != 'album' && $tsAction != 'favoritas' || $tsAction == 'ver'} active{/if}"><a href="{$tsConfig.url}/fotos/">Inicio</a></div>
         {if $tsAction == 'album' && $tsFUser.0 != $tsUser->uid}
            <div class="itemactive"><a href="{$tsConfig.url}/fotos/{$tsFUser.1}">&Aacute;lbum de {$tsFUser.1}</a></div>
         {/if}
         {if $tsUser->is_admod || $tsUser->permisos.gopf}
            <div class="item{if $tsAction == 'agregar'} active{/if}"><a href="{$tsConfig.url}/fotos/agregar.php">Agregar Foto</a></div>
         {/if}
          <div class="item{if $tsAction == 'album' && $tsFUser.0 == $tsUser->uid} active{/if}"><a href="{$tsConfig.url}/fotos/{$tsUser->nick}">Mis Fotos</a></div>
      {elseif $tsPage == 'tops'}
         <div class="item{if $tsAction == 'posts'} active{/if}"><a href="{$tsConfig.url}/top/posts/">Posts</a></div>
         <div class="item{if $tsAction == 'usuarios'} active{/if}"><a href="{$tsConfig.url}/top/usuarios/">Usuarios</a></div>
      {elseif $tsPage == 'files'}
         <div class="item{if $tsAction == '' && $tsAction != 'favoritos' && $tsAction != 'faqs'} active{/if}"><a href="{$tsConfig.url}/files/">Inicio</a></div>
         {if $tsUser->is_member}
            <div class="item"><a {if $folderUser.nombre}href="{$tsConfig.url}/files/{$filesUser.user_name}"{else}href="#" onclick="new_folder(); return false;"{/if}>{if $folderUser.nombre}Mis archivos{else}Crear carpeta{/if}</a></div>
            {if $filesUser.total_favs > 0}
            <div class="item{if $tsAction == 'favoritos'} active{/if}"><a href="{$tsConfig.url}/files/favoritos/">Favoritos</a></div>
            {/if}
         {/if}
         <div class="item{if $tsAction == 'faqs'} active{/if}"><a href="{$tsConfig.url}/files/faqs/">FAQs</a></div>
      {/if}
   </div>
</div>