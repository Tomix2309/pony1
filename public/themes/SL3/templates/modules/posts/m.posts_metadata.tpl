{if ($tsUser->is_admod || $tsUser->permisos.godp) && $tsUser->is_member == 1 && $tsPost.post_user != $tsUser->uid && $tsUser->info.user_puntosxdar >= 1}<ul class="stars">
   <b>Calificar</b>
   <span onclick="votar_post(1); return false;">1</span>
   <span onclick="votar_post(2); return false;">2</span>
   <span onclick="votar_post(3); return false;">3</span>
   <span onclick="votar_post(4); return false;">4</span>
   <span onclick="votar_post(5); return false;">5</span>
</ul>{/if}
<div class="post-metadata">
   <div style="display:none" class="mensajes"></div>
   <!-- NUEVO SISTEMA DE VOTOS -->
   <div class="sistema-de-votos my-3">
      <div class="total-de-votos">
         <div class="calificacion" aria-label="Calificación: {$tsPost.StarTotal} de cinco estrellas">{$tsPost.StarTotal}</div>
         <div class="my-1 position-relative">
            <div aria-label="Calificación: {$tsPost.StarTotal} de cinco estrellas">
               <div class="star-{if $tsPost.StarTotal >= 1}full{else}empty{/if} star"></div>
               <div class="star-{if $tsPost.StarTotal >= 2}full{else}empty{/if} star"></div>
               <div class="star-{if $tsPost.StarTotal >= 3}full{else}empty{/if} star"></div>
               <div class="star-{if $tsPost.StarTotal >= 4}full{else}empty{/if} star"></div>
               <div class="star-{if $tsPost.StarTotal >= 5}full{else}empty{/if} star"></div>
            </div>
         </div>
         <span class="calificacion-foot">
            <span class="peoples"></span>
            <span class="total" aria-label="{$tsPost.total_people} calificaciones">{$tsPost.total_people}</span> en total
         </span>
      </div>
      <div class="estadisticas-de-votos">
         <span class="d-block mb-1" data="5">5 <span star="{$tsPost.star5}" style="width:{if $tsPost.star5 == ''}0{else}{$tsPost.star5}{/if}%;" class="rounded bg-success"></span></span>
         <span class="d-block mb-1" data="4">4 <span star="{$tsPost.star4}" style="width:{if $tsPost.star4 == ''}0{else}{$tsPost.star4}{/if}%;" class="rounded bg-info"></span></span>
         <span class="d-block mb-1" data="3">3 <span star="{$tsPost.star3}" style="width:{if $tsPost.star3 == ''}0{else}{$tsPost.star3}{/if}%;" class="rounded bg-primary"></span></span>
         <span class="d-block mb-1" data="2">2 <span star="{$tsPost.star2}" style="width:{if $tsPost.star2 == ''}0{else}{$tsPost.star2}{/if}%;" class="rounded bg-warning"></span></span>
         <span class="d-block mb-1" data="1">1 <span star="{$tsPost.star1}" style="width:{if $tsPost.star1 == ''}0{else}{$tsPost.star1}{/if}%;" class="rounded bg-danger"></span></span>
      </div>
   </div>
   <!-- NUEVO SISTEMA DE VOTOS -->

   {*{if ($tsUser->is_admod || $tsUser->permisos.godp) && $tsUser->is_member == 1 && $tsPost.post_user != $tsUser->uid && $tsUser->info.user_puntosxdar >= 1}
      <div style="padding-bottom: 5px;" class="dar-puntos">
         {if $tsPunteador.rango >= 50}
            <div class="text-center" style="background: #F2F2F2;width: 58px;padding: 2px;">
               <input type="number" id="points" class="form-input" style="width:50px;height:15px;" value="{$tsPunteador.rango}" min="1" max="{$tsPunteador.rango}"/>  
               <input type="submit" onclick="votar_post(document.getElementById('points').value); return false;" value="Votar" class="btn btn-info" style="width: 55px;">  
            </div>
         {else}
            {section name=puntos start=1 loop=$tsUser->info.user_puntosxdar+1 max=$tsPunteador.rango}
               <a href="#" onclick="votar_post({$smarty.section.puntos.index}); return false;">{$smarty.section.puntos.index}</a> {if $smarty.section.puntos.index < $tsPunteador.rango}{/if}
            {/section}
         {/if}
         <span class="descrp">(de {$tsUser->info.user_puntosxdar} Disponibles)</span>
      </div>
   {/if}*}
   <div style="border-top: 1px solid #E0E0E0;width: 100%;"class="post-acciones">
      <ul class="list-unstyled d-flex justify-content-around">
         {if !$tsUser->is_member}
            <li><a class="btn btn-info" href="{$tsConfig.url}/registro/">Seguir Post</a></li>
         {elseif $tsPost.post_user != $tsUser->uid}
            <li{if !$tsPost.follow} style="display: none;"{/if}>
               <a class="btn btn-danger" onclick="notifica.unfollow('post', {$tsPost.post_id}, notifica.inPostHandle, $(this).children('span'))">Dejar de seguir</a>
            </li>
            <li{if $tsPost.follow > 0} style="display: none;"{/if}>
               <a class="btn btn-success" onclick="notifica.follow('post', {$tsPost.post_id}, notifica.inPostHandle, $(this).children('span'))">Seguir Post</a>
            </li>
            <li>
               <a href="javascript:{if !$tsUser->is_member}registro_load_form(){else}add_favoritos(){/if}" class="btn btn-warning">Agregar a Favoritos</a>
            </li>
            <li>
               <a href="javascript:denuncia.nueva('post',{$tsPost.post_id}, '{$tsPost.post_title}', '{$tsPost.user_name}')" class="btn btn-danger">Denunciar</a>
            </li>
          {/if}
      </ul>
   </div>
</div>         