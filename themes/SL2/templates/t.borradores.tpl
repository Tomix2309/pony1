{include file='sections/main_header.tpl'}
<!-- <script type="text/javascript" src="{$tsConfig.js}/borradores.js?{$smarty.now}"></script> -->
<div class="row">
	<div class="col-3">
		<div class="boxy">
         <div class="boxy-title">
            <h3>Filtrar</h3>
         </div><!-- boxy-title -->
         <div class="boxy-content">
            <h4>Mostrar</h4>
            <ul class="cat-list" id="borradores-filtros">
               <li id="todos" class="active">
               	<a href="" onclick="borradores.active(this); borradores.filtro = 'todos'; borradores.query(); return false;">Todos</a>
               	<span class="count"></span>
               </li>
               <li id="borradores">
               	<a href="" onclick="borradores.active(this); borradores.filtro = 'borradores'; borradores.query(); return false;">Borradores</a>
               	<span class="count"></span>
               </li>
               <li id="eliminados">
               	<a href="" onclick="borradores.active(this); borradores.filtro = 'eliminados'; borradores.query(); return false;">Eliminados</a>
               	<span class="count"></span>
               </li>
            </ul>
            <h4 class="mt-2">Ordenar por</h4>
            <ul id="borradores-orden" class="">
               <li class="bg-info d-flex justify-content-between align-items-center active">
               	<a href="javascript:borradores.orden('fecha_guardado')">Fecha guardado</a>
               </li>
               <li>
               	<a href="javascript:borradores.orden('titulo')">T&iacute;tulo</a>
               </li>
              <li>
              	<a href="javascript:borradores.orden('categoria')">Categor&iacute;a</a>
              </li>
            </ul>
            <h4 class="mt-2">Categorias</h4>
            <ul class="" id="borradores-categorias">
               <li id="todas" class="bg-info d-flex justify-content-between align-items-center active">
               	<a href="" onclick="borradores.active(this); borradores.categoria = 'todas'; borradores.query(); return false;">Ver todas</a>
               	<span class="text-white mr-3">{$tsTotalCat.total}</span>
               </li>
            </ul>
         </div><!-- boxy-content -->
      </div>
	</div>
	<div class="col-9">
		<!-- 
			$causa = empty($draft['b_causa']) ? '' : htmlspecialchars($draft['b_causa']);
			$tipos = array('eliminados', 'borradores'); 
		-->
      <div class="boxy">
      	<div class="boxy-title d-flex justify-content-between align-items-center">
         	<h3>Posts</h3>
            <input type="text" style="width: 300px;" placeholder="Buscar...." class="form-input" id="borradores-search" value="" onkeyup="borradores.search(this.value, event)" onfocus="borradores.search_focus()" onblur="borradores.search_blur()" autocomplete="off" />
          </div>
      </div>
		<div class="row" id="res">
		{foreach from=$tsDrafts.data item=p}
		<div class="col-lg-4 col-md-6 col-sm-12 col-12">
			<div class="last_posts position-relative" id="brd_{$p.bid}" itemscope itemtype="http://schema.org/CreateWork">
			   <img onclick="location.href='{$tsConfig.url}/agregar/{$p.bid}'" class="portada loading__lazyload" src="{$tsConfig.images}/loadImage.gif" data-src="{if $p.b_portada}{$p.b_portada}{else}{$p.post_cover}{/if}" />
			   <span onclick="location.href='{$tsConfig.url}/posts/{$p.c_seo}/'" data-cat="{$p.c_seo|truncate:2:''}" itemprop="genre"></span>
			   	<span style="position:absolute;margin-top:4px;left:4px" onclick="borradores.eliminar('{$p.bid}', true); return false;" class="btn btn-danger">Borrar</span>
			   <div class="data-info background__level--3">
			      <a href="{$tsConfig.url}/agregar/{$p.bid}" itemprop="name">{$p.b_title|truncate:40}</a>
			   	<div class="more-data">
			         <span><a href="{$tsConfig.url}/perfil/{$p.user_name}" itemprop="author" itemscope itemtype="http://schema.org/Person">@{$p.user_name}</a>
			            <small><span itemprop="datePublished" itemscope itemtype="http://schema.org/DateTime">&Uacute;ltima vez guardado {$p.b_date|hace}</span></small>
			         </span>
			         <span class="d-block text-danger fw-bold small bg-dark text-center py-1">{if $p.b_causa == ''}Eliminado por el autor{else}{$p.b_causa}{/if}</span>
			      </div>
			   </div>
				</div>
		</div>
		{/foreach}
		</div>
	</div>
</div>
{include file='sections/main_footer.tpl'}