{include file='sections/main_header.tpl'}
{literal}
<style>.d-grid,.resul{display:grid;grid-template-columns:1fr 75px;}.resul{grid-template-columns:1fr 175px;}.resul img{height:175px;object-fit:cover;}.d-grid input{border-radius:0;}.d-grid input[type=text]{border-right:none;}.d-grid input[type=submit]{border:0;}.userFound{margin:4px;min-width:170px;max-width:220px;padding:2px 4px;}.userFound img{width:40px;height:40px;margin-right:6px;}</style>
{/literal}
<script>
function buscador_select(type) {
   switch(type) {
      case 'web':
         $('#select_tags, #select_fotos').removeClass('btn-success');
         $('input[name=q]').attr('placeholder', 'Buscar posts');
      break;
      case 'tags':
         $('#select_web, #select_fotos').removeClass('btn-success');
         $('input[name=q]').attr('placeholder', 'Buscar tags');
      break;
      case 'fotos':
         $('#select_web, #select_tags').removeClass('btn-success');
         $('input[name=q]').attr('placeholder', 'Buscar fotos');
      break;
   }
   $('#select_'+type).addClass('btn-success');
   $('input[name="e"]').val(type);
}
</script>
<div class="row">
   <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="mb-2">
         <span class="fw-bold">Tipo de busqueda por...</span>
         <div class="d-flex justify-content-start align-items-center">
            <a class="btn btn-sm{if $tsEngine == 'web'} btn-success{/if}" href="javascript:buscador_select('web')" id="select_web">Web</a>
            <a class="btn btn-sm{if $tsEngine == 'tags'} btn-success{/if}" href="javascript:buscador_select('tags')" id="select_tags">Tags</a>
            <a class="btn btn-sm{if $tsEngine == 'fotos'} btn-success{/if}" href="javascript:buscador_select('fotos')" id="select_fotos">Fotos</a>
         </div>
      </div>
      <span class="fw-bold">Palabra clave</span>
      <form action="" method="GET" name="buscador">
         <div class="d-grid mb-2">
            <input type="text" placeholder="Buscar posts" value="{$tsQuery}" class="form-input" name="q"/>
            <input type="submit" value="Buscar" pattern="[a-zA-Z ]{literal}{2,50}{/literal}" class="bg-info text-center text-white border-0"/>
            <input type="hidden" name="e" value="{$tsEngine}" />
         </div>
         <h3 class="p-1 mt-2 m-0 bg-light">Filtrar por...</h3>
         <div class="py-2">
            <span class="fw-bold">Categorías:</span>
            <select name="cat" class="form-select">
               <option value="-1">Todas</option>
               {foreach from=$tsConfig.categorias item=c}
                  <option value="{$c.cid}"{if $tsCategory == $c.cid} selected="true"{/if}>{$c.c_nombre}</option>
               {/foreach}
            </select>
         </div>
         <div class="py-2">
            <span class="fw-bold">Autor:</span>
            <input type="text" class="form-input" placeholder="Usuario" name="autor" value="{$tsAutor}"/>
         </div>
      </form>
   </div>
   <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
      <h4>Buscar usuarios</h4>
      <small>Para buscar a todos, solo debes escribir "<b>todos</b>" y listo.</small>
      <div class="form-group" id="buscarusuario">
         <input type="text" name="usuario" pattern="[a-zA-Z ]{literal}{2,50}{/literal}" data-user="{$tsUser->uid}" placeholder="Nick del usuario." class="form-input">
      </div>
      <div id="resUser"></div>
      {if $tsQuery || $tsAutor}
         <h5 class="p-2 my-2">Mostrando <strong>{$tsResults.total}</strong> de <strong>{$tsResults.pages.total}</strong> resultados totales</h5>
         {if $tsResults.data}
         <div class="row">
            {foreach from=$tsResults.data item=r}
            {if $tsEngine == 'fotos'}
            <div class="col-md-6 mb-2" id="div_{$r.foto_id}">
               <div class="resul">
                  <div class="info">
                     <a class="d-block m-0 py-1 h4 text-dark" href="{$tsConfig.url}/fotos/{$r.user_name}/{$r.foto_id}/{$r.f_title|seo}.html">{$r.f_title}</a>
                     <small><a class="d-block text-dark" href="{$tsConfig.url}/buscador/?q={$r.f_title}&e=fotos&cat=-1&autor={$tsAutor}">Fotos Relacionados</a> 
                     <span class="d-block my-2"><a class="text-dark" href="{$tsConfig.url}/perfil/{$r.user_name}">@{$r.user_name}</a> - {$r.f_date|hace}</span>
                     
                     Votos positivos <strong>{$r.f_votos_pos}</strong> <br> Votos negativos <strong>{$r.f_votos_neg}</strong></small>
                  </div>
                  <img onclick="location.href='{$tsConfig.url}/fotos/{$r.user_name}/{$r.foto_id}/{$r.f_title|seo}.html'" class="portada rounded w-100 loading__lazyload" style="height:150px;" src="{$tsConfig.images}/loadImage.gif" data-src="{$r.f_url}" />
               </div>
            </div>
            {else}
            <div class="col-md-6 mb-2" id="div_{$r.post_id}">
               <div class="resul">
                  <div class="info">
                     <a class="d-block m-0 py-1 h4 text-dark" href="{$tsConfig.url}/posts/{$r.c_seo}/{$r.post_id}/{$r.post_title|seo}.html">{$r.post_title}</a>
                     <small><a class="d-block text-dark" href="{$tsConfig.url}/buscador/?q={$r.post_title}&e={$tsEngine}&cat={$tsCategory}&autor={$tsAutor}">Post Relacionados</a> 
                     <span class="d-block"><a class="text-dark" href="{$tsConfig.url}/perfil/{$r.user_name}">@{$r.user_name}</a> - {$r.post_date|hace}</span>
                     
                     Puntos <strong>{$r.post_puntos}</strong> <br> Favoritos <strong>{$r.post_favoritos}</strong> <br> Comentarios <strong>{$r.post_comments}</strong></small>
                  </div>
                  <img onclick="location.href='{$tsConfig.url}/posts/{$r.c_seo}/{$r.post_id}/{$r.post_title|seo}.html'" class="portada rounded shadow-3 w-100 loading__lazyload" src="{$tsConfig.images}/loadImage.gif" data-src="{if $r.post_portada}{$r.post_portada}{else}{$r.post_cover}{/if}" />
               </div>
            </div>
            {/if}
            {/foreach}
         </div>
         <div class="d-flex justify-content-around align-items-center">
            {if $tsResults.pages.prev != 0}
               <a class="btn btn-primary" href="{$tsConfig.url}/buscador/?page={$tsResults.pages.prev}{if $tsQuery}&q={$tsQuery}{/if}{if $tsEngine}&e={$tsEngine}{/if}{if $tsCategory}&cat={$tsCategory}{/if}{if $tsAutor}&autor={$tsAutor}{/if}">&laquo; Anterior</a>
            {/if}
            {if $tsResults.pages.next != 0}
               <a class="btn btn-primary" href="{$tsConfig.url}/buscador/?page={$tsResults.pages.next}{if $tsQuery}&q={$tsQuery}{/if}{if $tsEngine}&e={$tsEngine}{/if}{if $tsCategory}&cat={$tsCategory}{/if}{if $tsAutor}&autor={$tsAutor}{/if}">Siguiente &raquo;</a>
            {/if}
         </div>
         {else}
         <div class="hero hero-xl">
            <div class="hero-body">
               <h1>Lo siento!</h1>
               <p>No se encontraron resultados</p>
            </div>
         </div>
         {/if}
      {else}
         {if $tsQuery == ''}
         <div class="hero hero-info hero-xl">
            <div class="hero-body">
               <h1>Que quiere buscar?</h1>
               <p>Puede buscar: posts, fotos, tags y usuarios</p>
            </div>
         </div>
         {else}
         <div class="hero hero-danger hero-xl">
            <div class="hero-body">
               <h1>Lo siento!</h1>
               <p>No hemos podido encontrar lo que estabas buscando!</p>
            </div>
         </div>
         {/if}
      {/if}
   </div>
</div>
{include file='sections/main_footer.tpl'}