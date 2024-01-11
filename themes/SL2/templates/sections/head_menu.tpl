{if !$tsMobile}
   <div class="position-sticky navegation scroll w-100">
      <div class="container">
         <div class="navegation-columns">
            <div class="navegation-start">

               {if $tsConfig.c_allow_portal && $tsUser->is_member == true}
                  <div class="item{if $tsPage == 'mi'} active{/if}">
                     <a title="Ir a Inicio" href="{$tsConfig.url}/mi/"><i data-feather="home"></i> <span>Portal</span></a>
                  </div>
               {/if}
               <div class="item{if $tsPage == 'posts' || $tsPage == 'home'} active{/if}">
                  <a title="Ir a Posts" href="{$tsConfig.url}/posts/"> <i data-feather="file-text"></i> <span>Posts</span></a>
               </div> 
                {if $tsConfig.c_fotos_private == '1' && !$tsUser->is_member}{else}                      
                  <div class="item{if $tsPage == 'fotos'} active{/if}">
                     <a title="Ir a Fotos" href="{$tsConfig.url}/fotos/"><i data-feather="camera"></i><span>Fotos</span></a>
                  </div>                        
               {/if}
               <div class="item{if $tsPage == 'tops'} active{/if}">
                  <a title="Ir a TOPs" href="{$tsConfig.url}/top/"><i data-feather="trending-up"></i> <span>TOPs</span></a>
               </div>
               {if $tsUser->is_member}
                  {if $tsUser->is_admod == 1}
                     <div class="item{if $tsPage == 'admin'} active{/if}">
                        <a title="Panel de Administrador" href="{$tsConfig.url}/admin/"><i data-feather="layers"></i> <span>Administraci&oacute;n</span></a>
                     </div>
                  {/if}
               {else}
                  <div class="item">
                     <a alt="Iniciar sesión" class="text-info fw-bold" href="{$tsConfig.url}/login/">Acceder</a>
                  </div>
                  <div class="item">
                     <a alt="Crear mi cuenta" class="text-teal fw-bold" href="{$tsConfig.url}/registro/">Registrate!</a>
                  </div>
               {/if}
            </div>
            <div class="navegation-end">
               <form action="{$tsConfig.url}/buscador/" role="search" name="top_search_box">
                  <a title="Buscar" class="button-search" href="javascript:buscar_en_web(3)"><i data-feather="search"></i></a>
                  <div class="form-group w-100">
                     <input type="hidden" name="e" value="web" />
                     <input type="text" class="search-input" id="popup-search" value="" name="q" placeholder="Que deseas buscar...">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   {include file='sections/head_submenu.tpl'}
{/if}