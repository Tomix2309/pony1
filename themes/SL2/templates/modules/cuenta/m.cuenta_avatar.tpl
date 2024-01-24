<div class="avatares">
	<div class="row">
	   <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 avatar-cambiar">
	      <div onclick="avatar.accion.tipo('pc'); return false" class="box-type type-pc rounded bg-info text-center"><iconify-icon class="fs-2" icon="la:desktop"></iconify-icon> <span class="d-block">Desde PC</span></div>
	      <div onclick="avatar.accion.tipo('url'); return false" class="box-type type-url rounded bg-primary text-center"><iconify-icon class="fs-2" icon="la:link"></iconify-icon> <span class="d-block">Desde URL</span></div>
	   </div>
	   <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
	      <div class="grid-avatares" style="gap:1rem">
	      {foreach $tsAvatares item=ava}
	         <a class="avatar rounded" href="javascript:avatar.accion.seleccionar({$tsUser->uid}, {$ava.name})">
	            <img src="{$tsConfig.images}/loadImage.gif" 
	            data-src="{$tsCarpeta}/{$ava.img}" 
	            alt="Avatar #{$ava.name}" 
	            class="image rounded shadow img-fit-cover img-responsive">
	         </a>
	      {/foreach}
	      </div>
	      <div id="type-selection"></div>
	   </div>
	</div>
</div>