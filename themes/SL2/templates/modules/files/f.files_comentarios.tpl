<div class="file_box">
    <h2 class="fb_title">Comentarios<span class="fb_right" id="com_total">{$tsCom.total}</span></h2>
    <div class="fb_cuerpo" style="padding: 0">
    {if $tsCom.total > 0}
    {foreach from=$tsCom.com item=c}
    <div class="list_comfile" id="comfile_{$c.com_id}">
        <div class="FA_mini floatL">
            <a href="{$tsConfig.url}/perfil/{$c.user_name}" title="Ver perfil de {$c.user_name}">
                <img src="{$tsConfig.url}/files/avatar/{$c.com_user}_50.jpg" />
            </a>
        </div>
        <div class="FA_udatos">
            <strong><a href="{$tsConfig.url}/perfil/{$c.user_name}" title="Ver perfil de {$c.user_name}">{$c.user_name}</a></strong><span>{$c.com_fecha|hace}</span>{if $tsUser->is_admod} IP: {$c.com_ip}{/if}
        </div>
        <div class="FA_body">{$c.com_body|nl2br}</div>
        {if $c.com_user == $tsUser->uid || $tsUser->is_admod}
        <a class="del_comfile" onclick="borrar_comfile({$c.com_id}, {$tsFile.data.file_id}, false)">x</a>
        {/if}      
    </div>
    {/foreach}
    {else}
    <div id="sincom_file" class="emptyData" style="border: none;">No hay comentarios de este archivo.</div>
    {/if}
    <div id="add_new_com"></div>
    </div>
</div>
<div id="alertcom_file"></div>

<!-- AGREGAR NUEVO COMENTARIO -->

<div class="file_box" id="add_newcom">
    <h2 class="fb_title">A&ntilde;adir nuevo comentario <img src="{$tsConfig.images}/files/newcom_loader.gif" id="newcom_loader" /></h2>
    <div class="fb_cuerpo">   
    <textarea id="file_newcom" placeholder="Escribe un nuevo comentario para este archivo..."></textarea>
    <input type="button" onclick="file_newcom({$tsFile.data.file_id})" class="Abtn b_blue" value="Enviar" id="btn_newcom"/>
    </div>
</div>