{foreach from=$tsMuro.data item=p}
<div class="Story bg-white rounded mb-3" id="pub_{$p.pub_id}">

   <!-- Avatar | Nombre del usuario -->
   <a href="{$tsConfig.url}/perfil/{$p.user_name}" title="{if $tsUser->is_admod}{$p.p_ip}{else}{$p.user_name}{/if}" class="Story_Pic d-block text-center">
      <img class="shadow rounded w-100" alt="{$p.user_name}" src="{$tsConfig.url}/files/avatar/{$p.p_user_pub}.webp"/>
   </a>

   <!-- La publicación del usuario -->
   <div class="Story_Content d-block">
      <!-- Encabezado de la publicación -->
      <div class="Story_Head">
         {if $p.p_user == $tsUser->uid || $p.p_user_pub == $tsUser->uid || $tsUser->is_admod || $tsUser->permisos.moepm}
            <a href="#" class="float-end borrar" onclick="muro.del_pub({$p.pub_id},1); return false;" title="Eliminar la publicaci&oacute;n"><i data-feather="x"></i></a>
         {/if}
         <span class="text-capitalize">{if $p.user_name == $tsUser->nick}{$p.user_name}{else}{$p.user_name}{/if}</span>
      </div>
      <!-- Contenido de la publicación del usuario -->
      <div class="Story_Message p-2">
         <span>{$p.p_body|quot}</span>
         {if $p.p_type != 1}
            <div class="mvm clearfix">
               {if $p.p_type == 2}
                  <a href="#" onclick="muro.load_atta('foto', '{$p.a_url}', this); return false" class="uiPhoto"><img src="{$p.a_img}"/></a>
               {elseif $p.p_type == 3}
                  <div class="uiLink">
                     <strong class="d-block h4"><a href="{$p.a_url}" target="_blank" class="text-dark">{$p.a_title}</a></strong>
                     <span class="desc">{$p.a_url}</span>
                  </div>
               {elseif $p.p_type == 4}
                  <div class="uiVideo">
                     <a href="#" onclick="muro.load_atta('video','{$p.a_url}', this); return false;"class="uiVideoThumb">
                        <img class="w-100" alt="{$p.a_title}" src="http://img.youtube.com/vi/{$p.a_url}/0.jpg"/>
                        <i data-feather="play"></i>
                     </a>
                     <div class="videoDesc">
                        <a href="http://www.youtube.com/watch?v={$p.a_url}" target="_blank" class="fw-bolder">{$p.a_title}</a>
                        <div style="margin-top:5px">{$p.a_desc}</div>
                    </div>
                  </div>
               {/if}
            </div>
         {/if}
      </div>
      <!-- Pie de la publicación -->
      <div class="Story_Foot">
         <!-- Informacion de la publicación -->
         <div class="Story_Info d-flex justify-content-start align-items-center">
            <!-- Tipo de publicaciones:
               1 - Publicacion
               2 - Imagen
               3 - Enlace
               4 - video
            -->
            <i data-feather="{if $p.p_type == 1}book-open{elseif $p.p_type == 2}camera{elseif $p.p_type == 3}link{else}play{/if}"></i>
            <span class="text">{$p.p_date|hace}</span>
            <a style="" onclick="muro.like_this({$p.pub_id}, 'pub', this); return false;" class="">{$p.likes.link}</a>
            <a style="" onclick="muro.show_comment_box({$p.pub_id}); return false" class="">Comentar</a>
         </div>
         <ul id="cb_{$p.pub_id}" class="Story_Comments" {if $p.p_comments == 0 && $p.p_likes == 0}style="display:none"{/if}>
            <li class="lifi"><i></i></li>
            <li class="ufiItem" {if $p.p_likes == 0}style="display:none"{/if}>
               <div class="likes clearfix">
                  <i></i>
                  <span class="floatL" id="lk_{$p.pub_id}">{$p.likes.text}</span>
               </div>
            </li>
            <li>
               <ul id="cl_{$p.pub_id}" class="commentList">
                  {if $p.p_comments > 2 && !$p.hide_more_cm}
                     <li class="ufiItem">
                         <div class="more_comments alert alert-info text-center">
                             <i></i>
                             <a href="#" class="text-white" onclick="muro.more_comments({$p.pub_id}, this); return false">Ver los {$p.p_comments} comentarios</a>
                         </div>
                     </li>
                  {/if}
                  {foreach from=$p.comments item=c}
                     <li class="ufiItem" id="cmt_{$c.cid}">
                        <div class="clearfix">
                           <a href="{$tsConfig.url}/perfil/{$c.user_name}" class="autorPic"><img alt="{$c.user_name}" src="{$tsConfig.url}/files/avatar/{$c.c_user}.webp"/></a>
                           {if $p.p_user == $tsUser->uid || $c.c_user == $tsUser->uid  || $tsUser->is_admod || $tsUser->permisos.moecm}<span class="close"><a href="#" onclick="muro.del_pub({$c.cid}, 2); return false" class="uiClose" title="Eliminar"><i data-feather="x"></i></a></span>{/if}
                           <div class="mensaje">
                              <a href="{$tsConfig.url}/perfil/{$c.user_name}" class="autorName a_blue">{$c.user_name}</a>
                              <span>{$c.c_body|quot}</span>
                              <div class="cmInfo">{$c.c_date|hace} &middot; <a onclick="muro.like_this({$c.cid}, 'com', this); return false;" class="a_blue">{$c.like}</a> <span class="cm_like"{if $c.c_likes == 0} style="display:none"{/if}>&middot; <i></i> <a onclick="muro.show_likes({$c.cid}, 'com'); return false;" id="lk_cm_{$c.cid}" class="a_blue">{$c.c_likes} persona{if $c.c_likes > 1}s{/if}</a></span>{if $tsUser->is_admod} &middot;<span class="cmInfo">{$c.c_ip}</span>{/if}</div>
                           </div>
                        </div>
                     </li>
                  {/foreach}
               </ul> 
            </li>{if $tsPrivacidad.mf.v == true && $tsUser->is_member || $tsType == 'news'}
            <li class="ufiItem">
               <div class="newComment">
                  <div class="formulario">
                     <img src="{$tsConfig.url}/files/avatar/{$tsUser->uid}.webp"/>
                     <textarea class="comentar form-input" placeholder="Escribe un comentario..." id="cf_{$p.pub_id}" pid="{$p.pub_id}" name="add_wall_comment" onfocus="onfocus_input(this)" onblur="onblur_input(this)"></textarea>
                  </div>
               </div>
            </li>{/if}
         </ul>
      </div>
   </div>

</div>
{/foreach}