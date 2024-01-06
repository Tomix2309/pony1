{include file='sections/main_header.tpl'}
<script type="text/javascript" src="{$tsConfig.js}/perfil.js?{$smarty.now}"></script>
<script type="text/javascript" src="{$tsConfig.js}/portal.js?{$smarty.now}"></script>
<div class="row">
   <div id="portal" class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
      <div class="tabs_menu box_title">
         <ul id="tabs_menu">
            <li class="selected"><a onclick="portal.load_tab('news', this); return false">Noticias</a></li>
            <li><a onclick="portal.load_tab('activity', this); return false;">Actividad</a></li>
            <li><a onclick="portal.load_tab('posts', this); return false;">Posts</a></li>
            <li><a onclick="portal.load_tab('favs', this); return false;">Favoritos</a></li>
         </ul>
      </div> 
      <div id="portal_content"> 
         {include "$tsModulos/m.portal_noticias.tpl"}
         {include "$tsModulos/m.portal_activity.tpl"}
         {include "$tsModulos/m.portal_posts.tpl"}
         {include "$tsModulos/m.portal_posts_favoritos.tpl"}
      </div>
   </div>
   <div id="right_box" class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
      {include "$tsModulos/m.portal_posts_visitados.tpl"}
   </div>
</div>
{include file='sections/main_footer.tpl'}