<div id="post-comentarios">
   <div class="comentarios-title position-relative">
      <h4 class="titulorespuestas"><span id="ncomments">{$tsPost.post_comments}</span> Comentarios</h4>
      <div id="com_gif" style="display:none;top:10px;" class="loading loading-slow success position-absolute w-100"></div>
   </div>
   {if $tsPost.post_comments > $tsConfig.c_max_com}
      <div class="comentarios-title"><div class="paginadorCom"></div></div>
   {/if}
   <div id="comentarios">
      <script type="text/javascript">
      $(document).ready(function(){
         comentario.cargar({$tsPages.post_id}, 1, {$tsPages.autor});
      });
      </script>
      <div id="no-comments" class="alert text-center fw-bolder">Cargando comentarios espera un momento...</div>
   </div>
   {if $tsPost.post_comments > $tsConfig.c_max_com}
      <div class="comentarios-title"><div class="paginadorCom"></div></div>
   {/if}
   {if $tsPost.post_block_comments == 1 && ($tsUser->is_admod == 0 && $tsUser->permisos.mocepc == false)}
      <div id="no-comments" class="alert alert-warning">El post se encuentra cerrado y no se permiten comentarios.</div>
	{elseif $tsUser->is_admod == 0 && $tsUser->permisos.gopcp == false}
      <div id="no-comments" class="alert alert-danger">No tienes permisos para comentar.</div>
	{elseif $tsUser->is_member && ($tsPost.post_block_comments != 1 || $tsPost.post_user == $tsUser->uid || $tsUser->is_admod || $tsUser->permisos.gopcp) && $tsPost.block == 0}
      <div class="miComentario">
         <div id="procesando"><div id="post"></div></div>
         <div class="box-comentar">
            <div class="answerInfo">
               <img src="{$tsConfig.url}/files/avatar/{$tsUser->uid}.webp" class="avatar avatar-lg shadow avatar-rounded"/>
               <div id="gif_cargando" style="text-align:center; margin-top:1em; display:none">
                  <img src="{$tsConfig.images}/tload.gif" style="border:0;" />
               </div>
            </div>
            <div class="answerTxt">
               <div class="error"></div>
               <textarea id="body_comm" class="form-input" tabindex="1" title="Escribir un comentario..." style="resize:none;" onfocus="onfocus_input(this)" onblur="onblur_input(this)">Escribir un comentario...</textarea>
               <div class="buttons" >
                  <input type="hidden" id="auser_post" value="{$tsPost.post_user}" />
                  <input type="button" onclick="comentario.nuevo('true')" class="btn btn-success" value="Enviar Comentario" tabindex="3" id="btnsComment"/>
               </div>
            </div>
         </div>
		</div>
   {/if}
</div>