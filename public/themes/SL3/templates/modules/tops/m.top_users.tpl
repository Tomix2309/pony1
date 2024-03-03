<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
    <h2 class="text-uppercase text-center d-block p-2 bg-light">Top usuario con m&aacute;s...</h2>
   <div class="row">
    	<div class="boxy col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        	<div class="boxy-title">
                <h3>...Puntos</h3>
            </div>
            <div class="boxy-content">
            	{if !$tsTops.puntos}<div class="alert alert-warning text-center">Nada por aqui</div>
                {else}
            	<ol class="list-unstyled">
                	{foreach from=$tsTops.puntos item=u}
                    {if $u.total > 0}
                	<li class="mb-2 d-flex justify-content-start aling-items-center clearfix">
                        <img style="width:45px;height:45px;" class="rounded me-2" src="{$tsConfig.url}/files/avatar/{$u.user_id}.webp"/>
                        <span class="d-flex flex-column">
                            <a class="text-dark fw-bolder text-capitalize" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a> 
                            <span class="small">Tiene {$u.total} Punto{if $u.total > 1}s{/if}</span>
                        </span>
                    </li>
                    {/if}
                    {/foreach}
                </ol>
                {/if}
            </div>
        </div>
        <!--SEGUIDORES-->
    	<div class="boxy col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        	<div class="boxy-title">
                <h3>...Seguidores</h3>
            </div>
            <div class="boxy-content">
            	{if !$tsTops.seguidores}<div class="alert alert-warning text-center">Nada por aqui</div>
                {else}
            	<ol class="list-unstyled">
                	{foreach from=$tsTops.seguidores item=u}
                    {if $u.total > 0}
                	<li class="mb-2 d-flex justify-content-start aling-items-center clearfix">
                        <img style="width:45px;height:45px;" class="rounded me-2" src="{$tsConfig.url}/files/avatar/{$u.user_id}.webp"/>
                        <span class="d-flex flex-column">
                            <a class="text-dark fw-bolder text-capitalize" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a> 
                            <span class="small">Tiene {$u.total} Seguidor{if $u.total > 1}es{/if}</span>
                        </span>
                    </li>
                    {/if}
                    {/foreach}
                </ol>
                {/if}
            </div>
        </div>
	<!--MEDALLAS-->
    	<div class="boxy col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        	<div class="boxy-title">
                <h3>...Medallas</h3>
            </div>
            <div class="boxy-content">
            	{if !$tsTops.medallas}<div class="alert alert-warning text-center">Nada por aqui</div>
                {else}
            	<ol class="list-unstyled">
                	{foreach from=$tsTops.medallas item=u}
                    {if $u.total > 0}
                	<li class="mb-2 d-flex justify-content-start aling-items-center clearfix">
                        <img style="width:45px;height:45px;" class="rounded me-2" src="{$tsConfig.url}/files/avatar/{$u.user_id}.webp"/>
                        <span class="d-flex flex-column">
                            <a class="text-dark fw-bolder text-capitalize" href="{$tsConfig.url}/perfil/{$u.user_name}">{$u.user_name}</a> 
                            <span class="small">Tiene {$u.total} Medalla{if $u.total > 1}s{/if}</span>
                        </span>
                    </li>
                    {/if}
                    {/foreach}
                </ol>
                {/if}
            </div>
        </div>        
   </div>
</div>