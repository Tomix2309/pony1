{if !$tsMobile}  
   <nav class="position-sticky navbar-pill w-100">
      <ul class="{if !$tsMobile}container {/if}nav d-flex justify-content-start align-items-center position-relative">
         {if $tsConfig.c_allow_portal && $tsUser->is_member == true}
            <li class="nav-item{if $tsPage == 'mi'} active{/if}">
               <a title="Ir a Inicio" href="{$tsConfig.url}/mi/"><span>Portal</span> <i data-feather="home"></i></a>
            </li>
         {/if}
         <li class="nav-item{if $tsPage == 'posts' || $tsPage == 'home'} active{/if}">
            <a title="Ir a Posts" href="{$tsConfig.url}/posts/"><span>Posts</span>  <i data-feather="file-text"></i></a>
         </li>   
         {if $tsConfig.c_fotos_private == '1' && !$tsUser->is_member}{else}                      
            <li class="nav-item {if $tsPage == 'fotos'}active{/if}">
               <a title="Ir a Fotos" href="{$tsConfig.url}/fotos/"><span>Fotos</span> <i data-feather="camera"></i></a>
            </li>                        
         {/if}
         <li class="nav-item{if $tsPage == 'tops'} active{/if}">
            <a title="Ir a TOPs" href="{$tsConfig.url}/top/"><span>TOPs</span> <i data-feather="trending-up"></i></a>
         </li>
         {if $tsUser->is_member}
            {if $tsUser->is_admod == 1}
               <li class="nav-item{if $tsPage == 'admin'} active{/if}">
                  <a title="Panel de Administrador" href="{$tsConfig.url}/admin/"><span>Administraci&oacute;n</span> <i data-feather="sliders"></i></a>
               </li>
            {/if}
         {else}
            <li class="nav-item">
               <a alt="Iniciar sesión" class="text-info fw-bold" href="{$tsConfig.url}/login/">Acceder</a>
            </li>
            <li class="nav-item">
               <a alt="Crear mi cuenta" class="text-success fw-bold" href="{$tsConfig.url}/registro/">Registrate!</a>
            </li>
         {/if}
         {if !$tsMobile}
            <li class="nav-search position-absolute d-flex justify-content-center align-items-center">
               <input type="text" name="q" placeholder="Buscar..." class="form-input closed">
               <span><a class="d-flex justify-content-center align-items-center" title="Buscar" href="javascript:buscar_en_web(3)"><i data-feather="search"></i></a></span>
            </li>
         {else}
            <li class="nav-item">
               <a title="Buscar" href="javascript:buscar_en_web(1)"><i data-feather="search"></i></a>
            </li>
         {/if}
         <div id="results"></div>
      </ul>
   </nav>
   {include file='sections/head_submenu.tpl'}
{/if}