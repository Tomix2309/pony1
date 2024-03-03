1: 
<div class="item" id="div_cmnt_{$tsComment.0}">
<a href="{$tsConfig.url}/perfil/{$tsUser->nick}">
   <img src="{$tsConfig.url}/files/avatar/{$tsUser->info.user_id}.webp" class="rounded shadow"/>
</a>
<div class="firma">
   <div class="options position-relative">
      {if $tsComment.3 == $tsUser->uid}
         <a href="#" class="position-absolute" style="right:3px;top:3px" onclick="fotos.borrar({$tsComment.0}, 'com'); return false"><i data-feather="x"></i></a>
      {/if}
      <div class="comment-box" id="pp_{$c.cid}">
         <div class="comment-info">
            <a href="{$tsConfig.url}/fotos/{$tsUser->nick}" class="text-dark">@{$tsUser->nick}</a> <span> {$tsComment.2|hace} dijo:</span>
         </div>
         <div class="comment-content">{$tsComment.1|nl2br}</div>
      </div>
   </div>
</div>