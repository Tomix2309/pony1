<nav class="navbar navbar-expand-lg bg-body-tertiary" style="--bs-bg-opacity: .89;" data-bs-theme="dark">
	<div class="container-fluid">
		<a style="display: none;" class="navbar-brand" href="{$tsConfig.url}/" rel="internal">{$tsConfig.titulo}</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#SL2navigation" aria-controls="SL2navigation" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	 	<div class="collapse navbar-collapse" id="SL2navigation">
			<ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">	
				{if $tsConfig.c_allow_portal && $tsUser->is_member == true}
					<li class="nav-item"><a class="nav-link{if $tsPage == 'portal' || $tsPage == 'mi'} active{/if}" href="{$tsConfig.url}/mi/">Portal</a></li>
				{/if}
		  		<li class="nav-item dropdown">
		  			<a class="nav-link{if $tsPage == 'posts'} active{/if} dropdown-toggle" href="{$tsConfig.url}/{if $tsPage == 'home' || $tsPage == 'posts'}posts/{/if}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Posts</a>
			 		<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="{$tsConfig.url}/{if $tsPage == 'home' || $tsPage == 'posts'}posts/{/if}">Inicio</a></li>
						<li><a class="dropdown-item" href="{$tsConfig.url}/buscador/">Buscador</a></li>
						{if $tsUser->is_member}
							<li><hr class="dropdown-divider"></li>
							{if $tsUser->is_admod || $tsUser->permisos.gopp}
	                  	<li><a class="dropdown-item" ref="{$tsConfig.url}/agregar/">Agregar Post</a></li>
	                  {/if}
	              		<li><a class="dropdown-item" href="{$tsConfig.url}/mod-history/">Historial</a></li>
			        	   {if $tsUser->is_admod || $tsUser->permisos.moacp}
			               <li><a class="dropdown-item" href="{$tsConfig.url}/moderacion/">Moderaci&oacute;n {if $tsConfig.c_see_mod && $tsConfig.novemods.total}<span class="badge bg-{if $tsConfig.novemods.total < 10}success{elseif $tsConfig.novemods.total < 30}warning{else}danger{/if}" style="position:relative;">{$tsConfig.novemods.total}</span>{/if}</a></li>
			            {/if}
			         {/if}
			 		</ul>
		 		</li>
		 		{if $tsConfig.c_fotos_private != '1' && $tsUser->is_member}
			  		<li class="nav-item dropdown">
			  			<a class="nav-link{if $tsPage == 'fotos'} active{/if} dropdown-toggle" href="{$tsConfig.url}/fotos/" role="button" data-bs-toggle="dropdown" aria-expanded="false">Fotos</a>
				 		<ul class="dropdown-menu">
				 			<li><a class="dropdown-item" href="{$tsConfig.url}/fotos/">Inicio</a>
				         {if $tsAction == 'album' && $tsFUser.0 != $tsUser->uid}
				            <li><a class="dropdown-item" href="{$tsConfig.url}/fotos/{$tsFUser.1}">&Aacute;lbum de {$tsFUser.1}</a><li>
				         {/if}
				         {if $tsUser->is_admod || $tsUser->permisos.gopf}
				            <li><a class="dropdown-item">Agregar Foto</a><li>
				         {/if}
				         <li><a class="dropdown-item" href="{$tsConfig.url}/fotos/{$tsUser->nick}">Mis Fotos</a><li>
				 		</ul>
			 		</li>  
				{/if}
		  		<li class="nav-item dropdown">
		  			<a class="nav-link{if $tsPage == 'tops'} active{/if} dropdown-toggle" href="{$tsConfig.url}/top/" role="button" data-bs-toggle="dropdown" aria-expanded="false">TOPs</a>
			 		<ul class="dropdown-menu">
         			<li><a class="dropdown-item" href="{$tsConfig.url}/top/posts/">Posts</a></li>
         			<li><a class="dropdown-item" href="{$tsConfig.url}/top/usuarios/">Usuarios</a></li>
         			<li><a class="dropdown-item" href="{$tsConfig.url}/top/archivos/">Archivos</a></li>
			 		</ul>
		 		</li>
		  		<li class="nav-item dropdown">
		  			<a class="nav-link{if $tsPage == 'files'} active{/if} dropdown-toggle" href="{$tsConfig.url}/files/" role="button" data-bs-toggle="dropdown" aria-expanded="false">Archivos</a>
			 		<ul class="dropdown-menu">
			         <li><a class="dropdown-item" href="{$tsConfig.url}/files/">Inicio</a></li>
			         {if $tsUser->is_member}
			            <li><a class="dropdown-item" href="{$tsConfig.url}/files/mis-archivos/">Mis archivos</a></li>
			            {if $filesUser.total_favs > 0}
			               <li><a class="dropdown-item" href="{$tsConfig.url}/files/favoritos/">Mis Favoritos</a></li>
			            {/if}
			         {/if}
			         <li><a class="dropdown-item" href="{$tsConfig.url}/files/faqs/">FAQs</a></li>
			 		</ul>
		 		</li>
		 		{if !$tsUser->is_member}
					<div class="nav-item">
						<a alt="Iniciar sesión" class="btn btn-outline-warning me-2" href="{$tsConfig.url}/login/">Iniciar sesión</a>
					</div>
					<div class="nav-item">
						<a alt="Crear mi cuenta" class="btn btn-warning me-2" href="{$tsConfig.url}/registro/">Crear mi cuenta!</a>
					</div>
				{/if}
			</ul>
			<form class="d-flex" action="{$tsConfig.url}/buscador/" role="search" name="top_search_box">
				<a title="Buscar" role="button" class="button-search" href="javascript:buscar_en_web(3)"><i data-feather="search"></i></a>
				<input type="hidden" name="e" value="web" />
		  		<input class="rounded-pill" type="search" placeholder="Buscar..." aria-label="Buscar...">
			</form>
	 	</div>
  	</div>
</nav>