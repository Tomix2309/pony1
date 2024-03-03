<div class="post-info">
   <div class="tabs">
      <div class="tab-item leidos active" onclick="postsee.cambiar('leidos');return false">Lo más leido</div>
      <div class="tab-item comentados" onclick="postsee.cambiar('comentados');return false">Comentado</div>
   </div>
   <div id="moresee">
      {include 't.php_files/p.posts.moresee.tpl' nocache}
   </div>
</div>