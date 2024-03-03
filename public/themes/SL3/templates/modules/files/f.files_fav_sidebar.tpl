<div class="F_right">
    <div class="file_box">
        <h2 class="fb_title" align="center">{$tsUser->nick}</h2>
        <div class="fb_cuerpo" align="center" style="padding: 10px;">
            <div class="FA_avatar" style="margin: 0;">
                <a href="{$tsConfig.url}/perfil/{$tsUser->nick}" title="{$tsUser->nick}">
                    <img src="{$tsConfig.url}/files/avatar/{$tsUser->uid}_120.jpg" alt="Autor del archivo" />
                </a>
            </div>
        </div>
    </div>
    <div id="form_upload" align="center">
        <form id="New_upload" method="post" enctype="multipart/form-data">
             <div id="Select_file">
                 <a href="javascript: void(0);"class="Fbtn b_green list_text">Seleccionar archivo
                    <input type="file" name="archivo" id="New_file" />
                 </a>
                 <div class="result_text"></div>
             </div>
             <input type="submit" value="Subir archivo" id="start_upload" class="Fbtn b_blue" style="display: none;" />
         </form>
         <div id="progress">
            <div id="bar"></div>
            <div id="percent">0%</div >
        </div>            
        <div id="message"></div>
    </div>
    <br />
    {include file='modules/m.global_ads_160.tpl'}
</div>