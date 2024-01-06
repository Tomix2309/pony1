<div class="boxy-title">
   <h3>Administrar Categor&iacute;as</h3>
</div>
<div id="res" class="boxy-content">
   {if $tsSave}<div class="alert alert-info">Tus cambios han sido guardados.</div>{/if}
   {if $tsAct == ''}
      <h4>Categor&iacute;as</h4>
      <table class="table table-striped" id="cats_orden">
         <thead>
            <th>ID</th>
            <th>Icono</th>
            <th>Nombre</th>
            <th>Acciones</th>
         </thead>
         <tbody>{foreach from=$tsConfig.categorias item=c}
        	   <tr id="{$c.cid}">
            	<td width="30" class="text-center">{$c.c_orden}</td>
               <td width="40" class="text-center"><span class="text-uppercase fw-bolder">{$c.c_seo|truncate:2:''}</span></td>
               <td>{$c.c_nombre}</td>
               <td class="admin_actions" width="100">
                	<a href="?act=editar&cid={$c.cid}&t=cat" title="Editar Categor&iacute;a"><i data-feather="edit-3"></i></a>
                  <a href="?act=borrar&cid={$c.cid}&t=cat" title="Borrar Categor&iacute;a"><i data-feather="trash"></i></a>
               </td>
            </tr>{/foreach}
        </tbody>
        <tfoot>	
        	<td colspan="4">&nbsp;</td>
        </tfoot>
      </table><hr />
      <a href="{$tsConfig.url}/admin/cats?act=nueva&t=cat" class="btn btn-success">Agregar Nueva Categor&iacute;a</a>
      <a href="{$tsConfig.url}/admin/cats?act=change" class="btn btn-success">Mover Posts</a>								
	{elseif $tsAct == 'editar' || $tsAct == 'nueva'}
      <form action="" method="post" autocomplete="off">
         <fieldset>
            <legend>{if $tsAct == 'editar'}Editar{else}Nueva{/if} </legend>
               <dl>
                  <dt><label for="cat_name">Nombre de la categor&iacute;a:</label></dt>
                  <dd><input type="text" id="cat_name" name="c_nombre" class="form-input" value="{$tsCat.c_nombre}" /></dd>
               </dl>
               <p><input type="submit" {if $tsAct == 'editar'}name="save" value="Guardar cambios"{else}name="save" value="Crear Categor&iacute;a"{/if} class="btn btn-success"/></p>
         </fieldset>
      </form>
   {elseif $tsAct == 'borrar'}
      {if $tsError}<div class="alert alert-danger">{$tsError}</div>{/if}
      {if $tsType == 'cat'}
         <form action="" method="post" id="admin_form">
            <label for="h_mov">Borrar categor&iacute;a y mover las subcategor&iacute;as y demas datos a otra categor&iacute;a diferente. Mover datos a:</label>
            <select name="ncid" class="form-select">
               <option value="-1">Categor&iacute;as</option>
               {foreach from=$tsConfig.categorias item=c}
                  {if $c.cid != $tsCID}
                     <option value="{$c.cid}">{$c.c_nombre}</option>
                  {/if}
               {/foreach}
            </select>
            <hr />
            <input type="submit" name="save" value="Guardar cambios" class="btn btn-success">
         </form>	                                        
      {/if}
	{elseif $tsAct == 'change'}
      {if $tsError}<div class="alert alert-danger">{$tsError}</div>{/if}
      <form action="" method="post" id="admin_form">
         <label>Mover todos los posts de la categor&iacute;a </label>
         <select name="oldcid" class="form-select">
            <option value="-1">Categor&iacute;as</option>
          	{foreach from=$tsConfig.categorias item=c}
              	{if $c.cid != $tsCID}
              	   <option value="{$c.cid}">{$c.c_nombre}</option>
               {/if}
            {/foreach}
         </select>
			<label> a </label>
			<select name="newcid" class="form-select">
            <option value="-1">Categor&iacute;as</option>
            {foreach from=$tsConfig.categorias item=c}
               {if $c.cid != $tsCID}
                  <option value="{$c.cid}">{$c.c_nombre}</option>
               {/if}
            {/foreach}
         </select>
         <hr />
         <input type="submit" name="save" value="Guardar cambios" class="btn btn-success">
      </form>	                                        
   {/if}
</div>