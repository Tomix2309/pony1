{include file='sections/main_header.tpl'}
<script src="{$tsConfig.js}/agregar.js?{$smarty.now}"></script>
<div id="form_div">
	{if $tsUser->is_admod || $tsUser->permisos.gopp}
   <div class="form-add-post">
   	<form action="{$tsConfig.url}/agregar.php{if $tsAction == 'editar'}?action=editar&pid={$tsPid}{/if}" method="post" name="newpost" autocomplete="off" class="row">
       	<input type="hidden" value="{$tsDraft.bid}" name="borrador_id"/>
			<div class="col-xl-9 col-lg-9 col-md-9 col-sm col-12">
				<div style="display:none" id="preview"></div>
				<div id="contentPosts">{include "m.agregar_form.tpl"}</div>
				<div id="generator"></div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
        <span class="btn btn-gradient-seven d-block" id="GeneratorBtn">Generador de post</span>
        <span class="btn btn-gradient-three" style="display:none;" id="Aplicar">Aplicar al post!</span>
				<div class="form-group"> 
               <label class="form-label">Categor&iacute;a</label>
               <span style="display: none;" class="errormsg"></span>
               <select class="form-select required" tabindex="5" size="9" name="categoria">
               <option value="" selected="selected">Elegir una categor&iacute;a</option>
                  {foreach from=$tsConfig.categorias item=c}
                   	<option value="{$c.cid}" {if $tsDraft.b_category == $c.cid}selected="selected"{/if}>{$c.c_nombre}</option>
                  {/foreach}
               </select>
            </div>
            <div class="form-group">
               <label class="form-label">Opciones</label>

               <label class="form-checkbox cb-danger" for="privado">
    					<input type="checkbox" tabindex="6" name="privado" id="privado"{if $tsDraft.b_private == 1} checked{/if}>
    					<i class="form-icon"></i> S&oacute;lo usuarios registrados
  					</label>
               <label class="form-checkbox cb-danger" for="sin_comentarios">
    					<input type="checkbox" tabindex="7" name="sin_comentarios" id="sin_comentarios"{if $tsDraft.b_block_comments == 1} checked{/if}>
    					<i class="form-icon"></i> Cerrar Comentarios
  					</label>
               <label class="form-checkbox" for="visitantes">
    					<input type="checkbox" tabindex="8" name="visitantes" id="visitantes"{if $tsDraft.b_visitantes == 1} checked{/if}>
    					<i class="form-icon"></i> Mostrar visitantes recientes
  					</label>
               <label class="form-checkbox" for="smileys">
    					<input type="checkbox" tabindex="9" name="smileys" id="smileys"{if $tsDraft.b_smileys == 1} checked{/if}>
    					<i class="form-icon"></i> Sin Smileys
  					</label>
  					{if $tsUser->is_admod == 1}
               <label class="form-checkbox cb-success" for="patrocinado">
    					<input type="checkbox" tabindex="10" name="patrocinado" id="patrocinado"{if $tsDraft.b_sponsored == 1} checked{/if}>
    					<i class="form-icon"></i> Patrocinado
  					</label>
               {/if}
               {if $tsUser->is_admod || $tsUser->permisos.most}
               <label class="form-checkbox cb-success" for="sticky">
    					<input type="checkbox" tabindex="11" name="sticky" id="sticky"{if $tsDraft.b_sticky == 1} checked{/if}>
    					<i class="form-icon"></i> Sticky
  					</label>
               {/if}
            </div>
			</div>
		</form>
   </div>
{else}
	<div class="alert alert-warning fw-bold text-center">
     	Lo sentimos, pero no puedes publicar un nuevo post.
	</div>
{/if}
</div>
{include file='sections/main_footer.tpl'}