    <div id="live-stream" ntotal="{if !$tsStream.total}0{else}{$tsStream.total}{/if}" mtotal="{$tsMensajes.total}">
	{foreach from=$tsStream.data item=noti key=id}
    <div class="UIBeeper_Full background__level--3" id="beep_{$id}">
        <div class="Beeps">
            <div class="UIBeep">
                <a href="{$noti.link}" class="UIBeep_NonIntentional">
                    <div class="UIBeep_Icon action">
                        <span class="monac_icons ma_{$noti.style}"></span>
                    </div>
                    <div class="UIBeep_Title">
                    <span class="beeper_x" bid="{$id}"><i data-feather="x"></i></span>
                        <span class="fw-bold d-block">{if $noti.total == 1}{$noti.user}{else}{$tsConfig.titulo}{/if}</span> {$noti.text} <span class="blueName">{$noti.ltext}</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
    {/foreach}
    {foreach from=$tsMensajes.data item=mp key=id}
    <div class="UIBeeper_Full background__level--3" id="beep_m{$id}">
        <div class="Beeps">
            <div class="UIBeep">
                <a href="{$tsConfig.url}/mensajes/leer/{$mp.mp_id}" class="UIBeep_NonIntentional">
                    <div class="UIBeep_Icon">
                        <img src="{$tsConfig.url}/files/avatar/{$mp.mp_from}.webp"/>
                    </div>
                    <div class="UIBeep_Title">
                    <span class="beeper_x" bid="m{$id}"><i data-feather="x"></i></span>
                        <b class="d-block"><span feather="mail"></span>Nuevo mensaje</b>
                        <span class="blueName">{$mp.user_name}</span> <small class="d-block">{$mp.mp_preview}</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
    {/foreach}
</div>