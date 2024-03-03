<div class="pagination row">
   <!-- POST ANTERIOR -->
   <div class="prev{if $tsAnt.post_title == ''} grey{/if}">
      <a class="d-flex justify-content-start align-items-center" href="{if $tsAnt.post_title == ''}#UltimoPost{else}{$tsConfig.url}/posts/prev?id={if $tsAnt.post_id == ''}{$tsPost.post_id}{else}{$tsAnt.post_id}{/if}{/if}" title="{if $tsAnt.post_title == ''}{$tsPost.post_title}{else}{$tsAnt.post_title}{/if}">
         <div class="icon-box me-2">
            <i data-feather="chevron-left"></i>
         </div>                                    
         <div class="text">
            <p class="control">POST ANTERIOR</p>
            <p class="title">{if $tsAnt.post_title == ''}{$tsPost.post_title|truncate:40}{else}{$tsAnt.post_title|truncate:40}{/if}</p>
         </div>
      </a>
   </div>
   <!-- POST ALEATORIO -->
   <div class="next text-center">
      <a class="d-flex justify-content-center align-items-center" href="{$tsRandom}" title="Post aleatorio">
         <div class="text">
            <p class="control mb-1">POST RANDOM</p>
            <i data-feather="shuffle"></i>
         </div>
      </a>
   </div>
   <!-- POST SIGUIENTE -->
   <div class="next{if $tsSig.post_title == ''} grey{/if} text-right">
      <a class="d-flex justify-content-end align-items-center" href="{if $tsSig.post_title == ''}#UltimoPost{else}{$tsConfig.url}/posts/next?id={if $tsSig.post_id == ''}{$tsPost.post_id}{else}{$tsSig.post_id}{/if}{/if}" title="{if $tsSig.post_title == ''}{$tsPost.post_title}{else}{$tsSig.post_title}{/if}" style="border-right:none">
         <div class="text">
            <p class="control">POST SIGUIENTE</p>
            <p class="title">{if $tsSig.post_title == ''}{$tsPost.post_title|truncate:40}{else}{$tsSig.post_title|truncate:40}{/if}</p>
         </div>
         <div class="icon-box ms-2">
            <i data-feather="chevron-right"></i>
         </div>
      </a>
   </div>
</div>