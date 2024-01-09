<div class="last_posts" itemscope itemtype="http://schema.org/CreateWork">
   <img onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html'" class="portada loading__lazyload" src="{$tsConfig.images}/loadImage.gif" data-src="{if $p.post_portada}{$p.post_portada}{else}{$p.post_cover}{/if}" />
   <span onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'" data-cat="{$p.c_nombre|truncate:2:''}" itemprop="genre"></span>
   <div class="data-info background__level--3">
      <a href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" itemprop="name">{$p.post_title|truncate:40}</a>
      <div class="more-data">
         <span><a href="{$tsConfig.url}/perfil/{$p.user_name}" itemprop="author" itemscope itemtype="http://schema.org/Person">@{$p.user_name}</a>
            <small><span itemprop="datePublished" itemscope itemtype="http://schema.org/DateTime">{$p.post_date|hace}</span> {if $p.post_private}<i data-feather="lock" class="float-end" style="width:14px;height:14px;"></i>{/if}{if $p.post_sticky} <i data-feather="paperclip" class="float-end" style="width:14px;height:14px;"></i>{/if}</small>
         </span>
      </div>
   </div>
</div>