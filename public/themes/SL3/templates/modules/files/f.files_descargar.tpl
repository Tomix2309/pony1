<div class="py-4 text-center">
	{if $tsUser->is_member}
		<h2>Descargando su archivo</h2>
		<span>Su archivo <strong>{$tsFileToDownload.arc_name}.{$tsFileToDownload.arc_ext}</strong></span>
	{else}
		<h2>Lo siento</h2>
		<span>Para descargar este archivo: <strong>{$tsFileToDownload.arc_name}.{$tsFileToDownload.arc_ext}</strong><br> <a href="{$tsConfig.url}/login/" rel="internal" class="text-primary">Inicia sesión</a> o <a href="{$tsConfig.url}/registro/" rel="internal" class="text-primary">crea una cuenta</a>.</span>
	{/if}
</div>