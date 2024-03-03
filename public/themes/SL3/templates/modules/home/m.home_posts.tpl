<div class="last_posts mb-3 position-relative w-100 text-white" itemscope itemtype="http://schema.org/CreateWork">
   <img src="{$tsConfig.images}/loadImage.gif" data-src="{$p.post_portada}" class="image portada object-fit-cover rounded w-100" loading="lazy" alt="{$p.post_title}">
   <span onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'" itemprop="genre" class="position-absolute badge bg-secondary-subtle text-secondary-emphasis">{$p.c_nombre}</span>
   <div class="data-info p-2 bg-dark bg-opacity-75 backdrop_filter--4">
      <a class="text-truncate w-100" rel="internal" href="{$tsConfig.url}/posts/{$p.c_seo}/{$p.post_id}/{$p.post_title|seo}.html" itemprop="name">{$p.post_title}</a>
      <div class="more-data">
         <span><a class="d-block" href="{$tsConfig.url}/perfil/{$p.user_name}" itemprop="author" itemscope itemtype="http://schema.org/Person">{$p.user_name}</a>
            <small><span itemprop="datePublished">{$p.post_date|hace}</span> {if $p.post_private}<i data-feather="lock" class="float-end" style="width:14px;height:14px;"></i>{/if}{if $p.post_sticky} <i data-feather="paperclip" class="float-end" style="width:14px;height:14px;"></i>{/if}</small>
         </span>
      </div>
   </div>
</div>
