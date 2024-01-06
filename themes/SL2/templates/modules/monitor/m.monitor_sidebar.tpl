<div id="post-izquierda">
   <h2 class="bg-light p-2 h4">Filtrar Actividad</h2>
   <ul class="list-unstyled">
      <li class="alert alert-info text-center">Elige que notificaciones recibir y cuales no.</li>
      <li class="divider"></li>
      <li class="text-info h6 mt-2"><strong>Mis Posts</strong></li>
      <li><label><span class="monac_icons ma_star"></span><input type="checkbox" {if $tsData.filtro.f1 != true} checked{/if} onclick="notifica.filter('1', this)"/> Favoritos</label></li>
      <li><label><span class="monac_icons ma_comment_post"></span><input type="checkbox" {if $tsData.filtro.f2 != true} checked{/if} onclick="notifica.filter('2', this)"/> Comentarios</label></li>
      <li><label><span class="monac_icons ma_points"></span><input type="checkbox" {if $tsData.filtro.f3 != true} checked{/if} onclick="notifica.filter('3', this)"/> Puntos Recibidos</label></li>
      <li class="text-info h6 mt-2"><strong>Mis Comentarios</strong></li>
      <li><label><span class="monac_icons ma_voto"></span><input type="checkbox" {if $tsData.filtro.f8 != true} checked{/if} onclick="notifica.filter('8', this)"/> Votos</label></li>
      <li><label><span class="monac_icons ma_comment_resp"></span><input type="checkbox" {if $tsData.filtro.f9 != true} checked{/if} onclick="notifica.filter('9', this)"/> Respuestas</label></li>
      <li class="text-info h6 mt-2"><strong>Usuarios que sigo</strong></li>
      <li><label><span class="monac_icons ma_follow"></span><input type="checkbox" {if $tsData.filtro.f4 != true} checked{/if} onclick="notifica.filter('4', this)"/> Nuevos</label></li>
      <li><label><span class="monac_icons ma_post"></span><input type="checkbox" {if $tsData.filtro.f5 != true} checked{/if} onclick="notifica.filter('5', this)"/> Posts</label></li>
      <li><label><span class="monac_icons ma_photo"></span><input type="checkbox" {if $tsData.filtro.f10 != true} checked{/if} onclick="notifica.filter('10', this)"/> Fotos</label></li>
      <li><label><span class="monac_icons ma_share"></span><input type="checkbox" {if $tsData.filtro.f6 != true} checked{/if} onclick="notifica.filter('6', this)"/> Recomendaciones</label></li>
      <li class="text-info h6 mt-2"><strong>Posts que sigo</strong></li>
      <li><label><span class="monac_icons ma_blue_ball"></span><input type="checkbox" {if $tsData.filtro.f7 != true} checked{/if} onclick="notifica.filter('7', this)"/> Comentarios</label></li>
      <li class="text-info h6 mt-2"><strong>Mis Fotos</strong></li>
      <li><label><span class="monac_icons ma_comment_post"></span><input type="checkbox" {if $tsData.filtro.f11 != true} checked{/if} onclick="notifica.filter('11', this)"/> Comentarios</label></li>
      <li class="text-info h6 mt-2"><strong>Perfil</strong></li>
      <li><label><span class="monac_icons ma_status"></span><input type="checkbox" {if $tsData.filtro.f12 != true} checked{/if} onclick="notifica.filter('12', this)"/> Publicaciones</label></li>
      <li><label><span class="monac_icons ma_w_comment"></span><input type="checkbox" {if $tsData.filtro.f13 != true} checked{/if} onclick="notifica.filter('13', this)"/> Comentarios</label></li>
      <li><label><span class="monac_icons ma_w_like"></span><input type="checkbox" {if $tsData.filtro.f14 != true} checked{/if} onclick="notifica.filter('14', this)"/> Likes</label></li>
   </ul>
   <h2 class="bg-light mt-3 p-2 h5">Estad&iacute;sticas</h2>
   <ul class="list-unstyled">
      <li class="py-1"><a href="{$tsConfig.url}/monitor/seguidores" class="text-dark d-flex justify-content-between align-items-center">
         <span>Seguidores</span>
         <span class="badge badge-info">{$tsData.stats.seguidores}</span></a>
      </li>
      <li class="py-1"><a href="{$tsConfig.url}/monitor/siguiendo" class="text-dark d-flex justify-content-between align-items-center">
         <span>Usuarios Siguiendo</span>
         <span class="badge badge-info">{$tsData.stats.siguiendo}</span></a>
      </li>
      <li class="py-1"><a href="{$tsConfig.url}/monitor/posts" class="text-dark d-flex justify-content-between align-items-center">
         <span>Posts</span>
         <span class="badge badge-info">{$tsData.stats.posts}</span></a>
      </li>
   </ul>
   {if $tsConfig.c_allow_live == 1}
      <h2 class="bg-light mt-3 p-2 h5">Notificaciones Live</h2>
      <ul class="list-unstyled">
         <li class="py-1"><label><input type="checkbox" {if $tsStatus.live_nots == 'ON'} checked{/if} onclick="live.ch_status('nots');"/> <b>Mostrar notificaciones</b></label></li>
         <li class="py-1"><label><input type="checkbox" {if $tsStatus.live_mps == 'ON'} checked{/if} onclick="live.ch_status('mps');"/> <b>Mostrar mensajes nuevos</b></label></li>
         <li class="py-1"><label><input type="checkbox" {if $tsStatus.live_sound == 'ON'} checked{/if} onclick="live.ch_status('sound');"/> <b>Reproducir sonidos</b></label></li>
      </ul>
   {/if}
</div>