<div class="F_left">
    <div class="file_box">
        <h2 class="fb_title">Mis archivos favoritos<span class="fb_right" id="Favs_total">{$favFiles.total}</span></h2>
        <div class="fb_cuerpo" style="padding: 0px;overflow: hidden;">
            {if $favFiles.total > 0}
            <div class="F_files">
                {foreach from=$favFiles.data item=a}
                <div class="list_file" id="Favid_{$a.fav_id}" {if $a.f_estado == 0}style="opacity: 0.5;" title="Este archivo est&aacute; desabilitado"{/if}>
                    <a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}">
                    <div class="File_format">
                        <img src="{$tsConfig.images}/files/file.png" height="55"/>
                        <span>{$a.f_ext}</span>
                    </div>
                    </a>
                    <div class="F_info">
                        <a href="{$tsConfig.url}/files/{$a.file_id}/{$a.f_nombre|seo}"><h2>{$a.f_nombre}</h2></a>
                        Añadido {$a.fav_fecha|fecha}
                        Subido por: <strong><a href="{$tsConfig.url}/perfil/{$a.user_name}" title="Ver perfil de {$a.user_name}">{$a.user_name}</a></strong>
                        Tama&ntilde;o: {$a.f_peso}<br />
                        <a href="#" onclick="download_file({$a.file_id}); return false;">Descargar</a> |
                        <a href="#" onclick="borrar_fav({$a.fav_id}, false); return false;">Borrar favorito</a>
                    </div>
                    <div class="F_descarga">
                        
                    </div>
                </div>
                {/foreach}
            </div>
            {else}
            <div class="emptyData">No has agregado ning&uacute;n archivo a favorito.</div>
            {/if}
        </div>
    </div>
    
    <br />
    <div style="overflow: hidden;">{include file='modules/m.global_ads_728.tpl'}</div>
    <br />
</div>