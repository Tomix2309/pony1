                    <script type="text/javascript">
                        imagenes.total = {$tsImTotal-1};
                        imagenes.move = '-185px';
                    </script>
					<div style="margin-top: -3px;" id="lastFotos" class="wMod clearbeta">
                        <div class="wMod-data" style="padding:0;text-align:center;position:relative;height: 185px;overflow: hidden;">
                            <ul id="imContent" style="position:absolute;top:-150px;">
                            {foreach from=$tsImages.data item=im key=i}
                            <li id="img_{$i}">
                                <a href="{$tsConfig.url}/fotos/{$im.user_name}/{$im.foto_id}/{$im.f_title|seo}.html" title="{$im.f_caption}">
                                    <img src="{$im.f_url}" style="height:185px; width:300px" align="absmiddle"/>
                                </a>
                            </li>
                            {/foreach}
                            </ul>
                        </div>
						<a href="{$tsConfig.url}/fotos/agregar/"><li class="op_plus"><img src="{$tsConfig.tema.t_url}/mega/plus.png" style="height:16px; width:16px" align="absmiddle"/>&nbsp;&nbsp;&nbspAgregar &nbsp;Foto</li></a>
                    </div>