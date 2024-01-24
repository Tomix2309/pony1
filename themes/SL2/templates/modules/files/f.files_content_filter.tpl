<div class="filtrar-archivos position-sticky">
	<h4>Archivos</h4>
	<ul class="nav nav-pills flex-column">
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o=name{if $mode}&m={$mode}{/if}{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $order == 'name'} active{/if}">Nombre</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o=date{if $mode}&m={$mode}{/if}{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $order == 'date'} active{/if}">Fecha</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o=weight{if $mode}&m={$mode}{/if}{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $order == 'weight'} active{/if}">Peso</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o=downloads{if $mode}&m={$mode}{/if}{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $order == 'downloads'} active{/if}">Descargas</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o=ext{if $mode}&m={$mode}{/if}{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $order == 'ext'} active{/if}">Tipo</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o=folder{if $mode}&m={$mode}{/if}{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $order == 'folder'} active{/if}">Carpetas</a></li>
	</ul>
	<hr>
	<h4>Ordernar</h4>
	<ul class="nav flex-column">
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o={$order}&m=d{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $mode == 'd'} active{/if}">Descendente</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o={$order}&m=a{if $page}&s={$page}{/if}{if $author}&a={$author}{/if}" class="nav-link{if $mode == 'a'} active{/if}">Ascendente</a></li>
	</ul>
	<hr>
	<h4>Cuales?</h4>
	<ul class="nav flex-column">
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o={$order}&m=a{if $page}&s={$page}{/if}{if $author}&a=mine{/if}" class="nav-link{if $author == 'mine'} active{/if}">Mis Archivos</a></li>
		<li class="nav-item"><a href="{$tsConfig.url}/files/?o={$order}&m=a{if $page}&s={$page}{/if}{if $author}&a=all{/if}" class="nav-link{if $author == 'all'} active{/if}">Todos los archivos</a></li>
	</ul>
</div>