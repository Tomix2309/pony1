<div class="box-lateral" id="topsUserBox">
   <div class="box-header">Tops Usuarios <i data-feather="activity"></i></div>
   <div class="filter">
      <a href="javascript:TopsTabs('topsUserBox','AyerUser')" id="AyerUser">Ayer</a>
      <a href="javascript:TopsTabs('topsUserBox','SemanaUser')" id="SemanaUser">Semana</a>
      <a href="javascript:TopsTabs('topsUserBox','MesUser')" id="MesUser"{if $tsTopUsers.mes} class="active"{/if}>Mes</a>
      <a href="javascript:TopsTabs('topsUserBox','HistoricoUser')" id="HistoricoUser" {if !$tsTopUsers.mes}class="active"{/if}>Hist&oacute;rico</a>
   </div>
   <ol id="filterByAyerUser" class="filterBy" style="display:none;">
      {foreach from=$tsTopUsers.ayer key=i item=u}
         <li>
            {if $i+1 < 10}0{/if}{$i+1}.
            <a class="text-dark" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a>
            <span class="badge badge-success float-end">{$u.total}</span>
         </li>
      {/foreach}
   </ol>
   <ol id="filterBySemanaUser" class="filterBy" style="display:none;">
      {foreach from=$tsTopUsers.semana key=i item=u}
         <li>
            {if $i+1 < 10}0{/if}{$i+1}.
            <a class="text-dark" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a>
            <span class="badge badge-success float-end">{$u.total}</span>
         </li>
      {/foreach}
   </ol>
   <ol id="filterByMesUser" class="filterBy" style="display:{if $tsTopUsers.mes}block{else}none{/if};">
      {foreach from=$tsTopUsers.mes key=i item=u}
         <li>
            {if $i+1 < 10}0{/if}{$i+1}.
            <a class="text-dark" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a>
            <span class="badge badge-success float-end">{$u.total}</span>
         </li>
      {/foreach}
   </ol>
   <ol id="filterByHistoricoUser" class="filterBy" style="display:{if !$tsTopUsers.mes}block{else}none{/if};">
      {foreach from=$tsTopUsers.historico key=i item=u}
         <li>
            {if $i+1 < 10}0{/if}{$i+1}.
            <a class="text-dark" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a>
            <span class="badge badge-success float-end">{$u.total}</span>
         </li>
      {/foreach}
   </ol>
</div>

<div class="box-lateral" id="topsPostBox">
   <div class="box-header">Tops Posts <i data-feather="activity"></i></div>
   <div class="filter">
      <a href="javascript:TopsTabs('topsPostBox','Ayer')" id="Ayer">Ayer</a>
      <a href="javascript:TopsTabs('topsPostBox','Semana')" id="Semana"{if $tsTopPosts.semana} class="active"{/if}>Semana</a>
      <a href="javascript:TopsTabs('topsPostBox','Mes')" id="Mes">Mes</a>
      <a href="javascript:TopsTabs('topsPostBox','Historico')" id="Historico"{if !$tsTopPosts.semana} class="active"{/if}>Hist&oacute;rico</a>
   </div>
   <ol id="filterByAyer" class="filterBy cleanlist" style="display:none;">
      {foreach from=$tsTopPosts.ayer key=i item=p}
      <li>
         {if $i+1 < 10}0{/if}{$i+1}.
         <a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" class="text-dark">{$p.post_title|truncate:20}</a>
         <span class="badge badge-success float-end">{$p.post_puntos}</span>
      </li>
      {/foreach}
   </ol>
   <ol id="filterBySemana" class="filterBy cleanlist" style="display:{if $tsTopPosts.semana}block{else}none{/if};">
      {foreach from=$tsTopPosts.semana key=i item=p}
      <li>
         {if $i+1 < 10}0{/if}{$i+1}.
         <a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" class="text-dark">{$p.post_title|truncate:20}</a>
         <span class="badge badge-success float-end">{$p.post_puntos}</span>
      </li>
      {/foreach}
   </ol>
   <ol id="filterByMes" class="filterBy cleanlist" style="display:none;">
      {foreach from=$tsTopPosts.mes key=i item=p}
      <li>
         {if $i+1 < 10}0{/if}{$i+1}.
         <a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" class="text-dark">{$p.post_title|truncate:20}</a>
         <span class="badge badge-success float-end">{$p.post_puntos}</span>
      </li>
      {/foreach}
   </ol>
   <ol id="filterByHistorico" class="filterBy cleanlist" style="display:{if !$tsTopPosts.semana}block{else}none{/if};">
      {foreach from=$tsTopPosts.historico key=i item=p}
      <li>
         {if $i+1 < 10}0{/if}{$i+1}.
         <a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" class="text-dark">{$p.post_title|truncate:20}</a>
         <span class="badge badge-success float-end">{$p.post_puntos}</span>
      </li>
      {/foreach}
   </ol>
</div>