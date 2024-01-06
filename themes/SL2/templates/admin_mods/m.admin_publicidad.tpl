<div class="boxy-title">
    <h3>Administrar Publicidad</h3>
</div>
<div id="res" class="boxy-content">
{if $tsSave}<div class="alert alert-info">Tus cambios han sido guardados.</div>{/if}
    <form action="" method="post" autocomplete="off">
        <fieldset>
            <legend>C&oacute;digos</legend>
            <dl>
                <dt><label for="ai_ban_1">Banner 300x250:</label></dt>
                <dd><textarea name="ad300" id="ai_ban_1" rows="5" cols="50">{$tsConfig.ads_300}</textarea></dd>
            </dl>
            <dl>
                <dt><label for="ai_ban_2">Banner 468x60:</label></dt>
                <dd><textarea name="ad468" id="ai_ban_2" rows="5" cols="50">{$tsConfig.ads_468}</textarea></dd>
            </dl>
            <dl>
                <dt><label for="ai_ban_3">Banner 160x600:</label></dt>
                <dd><textarea name="ad160" id="ai_ban_3" rows="5" cols="50">{$tsConfig.ads_160}</textarea></dd>
            </dl>
            <dl>
                <dt><label for="ai_ban_4">Banner 728x90:</label></dt>
                <dd><textarea name="ad728" id="ai_ban_4" rows="5" cols="50">{$tsConfig.ads_728}</textarea></dd>
            </dl>
            <dl>
                <dt><label for="ai_ban_5">Search ID:</label><span>ID de tu buscador de GOOGLE</span></dt>
                <dd><input type="text" name="adSearch" id="ai_ban_5" value="{$tsConfig.ads_search}" /></dd>
            </dl>
            <p><input type="submit" value="Guardar cambios" name="save" class="btn btn-success"/></p>
        </fieldset>
    </form>
</div>